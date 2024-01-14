<template>
    <div>
        <input type="text" 
            class="shadow appearance-none border rounded w-full py-2 px-3 mr-4 text-grey-darker placeholder:text-transparent focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent" 
            placeholder="Add Todo" 
            v-model="newTodo" 
            @keyup.enter="addTodo"    
        >
        <transition-group name="fade" enter-active-class="animated fadeInUp" leave-active-class="animated fadeOutDown">
            <div v-for="(todo, index) in todosFiltered" :key="todo.id" class="animation">
                <div class="flex mb-4">
                    <input type="checkbox" 
                        v-model="todo.completed" 
                        @click="doneEdit(todo)"
                    >
                    <div v-if="!todo.editing" @dblclick="editTodo(todo)" class="ml-4" >
                        <h5 class="w-64 text-grey-darkest text-xl" :class="{ completed : todo.completed }" >{{ todo.title }}</h5>
                    </div>
                    <input v-else type="text"
                        autofocus  
                        class="shadow appearance-none border rounded w-64 mr-4 ml-4 text-grey-darker placeholder:text-transparent focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent"
                        v-model="todo.title" 
                        @blur="doneEdit(todo)" 
                        @keyup.enter="doneEdit(todo)"
                        @keyup.esc="cancelEdit(todo)"
                    >
                    <div class="text-black hover:text-yellow cursor-pointer ml-auto" @click="removeTodo(index)">
                        &times;
                    </div>
                </div>
            </div>
        </transition-group>
        <hr class="h-px my-4 bg-gray-300 border-0">
        <div class="justify-between">
            <div class="text-center">
                <h3>{{ remaining }} Tasks left.</h3>
            </div>
        </div>
        <hr class="h-px my-4 bg-gray-300 border-0">
        <div>
            <div class="flex items-center mt-4 flex-col md:flex-row">
                <button type="button" 
                    class="w-full border-l border-t border-b text-base font-medium rounded-l-md text-black bg-white hover:bg-gray-100 px-4 py-2" 
                    :class="{ active: filter == 'all' }" 
                    @click="filter = 'all'"
                >
                All
                </button>
                <button type="button" 
                    class="w-full border text-base font-medium text-black bg-white hover:bg-gray-100 px-4 py-2" 
                    :class="{ active: filter == 'active' }" 
                    @click="filter = 'active'"
                >
                Active
                </button>
                <button type="button" 
                    class="w-full border text-base font-medium text-black bg-white hover:bg-gray-100 px-4 py-2" 
                    :class="{ active: filter == 'completed' }" 
                    @click="filter = 'completed'"
                >
                 Completed
                </button>
            </div>
        </div>
    </div>
    </template>
    
    <script>
    import axios from 'axios';

    export default {
        name: 'todo-list',
        data() {
            return {
                newTodo: '',
                idForTodo: '',
                beforeEditCache: '',
                filter: 'active',
                todos: []
            }
        },
        watch: {
            filter(newFilter, oldFilter) {
                console.log(`Filter changed from ${oldFilter} to ${newFilter}`);
            },
        },
        computed: {
            completed() {
                return this.todos.filter(todo => todo.completed).length
            },  
            remaining() {
                return this.todos.filter(todo => !todo.completed).length
            },
            anyRemaining() {
                return this.remaining != 0
            },
            todosFiltered() {
                if(this.filter == 'all') {
                    return this.todos
                }
                else if (this.filter == 'active') {
                    return this.todos.filter(todo => !todo.completed)
                }
                else if (this.filter == 'completed') {
                    return this.todos.filter(todo => todo.completed)
                }
            },
            showClearCompletedButton() {
                if (this.filter == 'completed'){
                    return
                }
                if (this.remaining != 0){
                    return this.todosFiltered.filter(todo => todo.completed).length > 0
                }
            },
        },
        methods: {
            async getTodos() {
                try {
                    const response = await axios.get('http://127.0.0.1:8000/api/');
                    console.log(response.data);
                    this.todos = response.data;
                } catch (error) {
                    console.error('Błąd pobierania użytkowników:', error);
                }
            },
            addTodo() {
                if(this.newTodo.trim().length == 0) {
                    return
                }

                const Todo = {
                    title: this.newTodo,
                    completed: false,
                };

                try {
                    const response = axios.post('/api/create', Todo);

                    response.then(response => {
                        this.idForTodo = response.data.id

                        this.todos.push({
                            id: this.idForTodo,
                            title: this.newTodo,
                            completed: false,
                            editing: false,
                        })

                        this.newTodo = ''
                    })
                }
                catch (error) {
                    console.error('Błąd wysyłania wiadomości:', error);
                }
            },
            editTodo(todo) {
                this.beforeEditCache = todo.title;
                todo.editing = true;
            },
            doneEdit(todo) {
                if (todo.title.trim() == '') {
                    todo.title = this.beforeEditCache
                }
                if (todo.id > this.idForTodo) {
                    this.idForTodo = todo.id
                }

                this.completedTodo = todo.completed = event.target.checked

                const newTodo = {
                    id: this.idForTodo,
                    title: todo.title,
                    completed: this.completedTodo,
                };

                try {
                    axios.put('/api/update/' + this.idForTodo, newTodo);       
                    this.newTodo = ''
                }
                catch (error) {
                    console.error('Błąd wysyłania wiadomości:', error);
                }

                todo.editing = false;
            },
            cancelEdit(todo) {
                todo.title = this.beforeEditCache
                todo.editing = false;
            },
            removeTodo(index) {
                if(this.filter == 'active'){
                    index = index + this.completed
                    this.todo = (this.todos[index])
                }
                else {
                    this.todo = (this.todos[index])
                }

                try {
                    axios.delete('/api/delete/' + this.todo.id);
                    this.todos.splice(index, 1);
                }
                catch (error) {
                    console.error('Błąd wysyłania wiadomości:', error);
                }
            },
        },
        mounted() {
            this.getTodos();
        }
    }
    </script>
    
    <style scoped>
    @import url("https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css");

    .active {
        background-color: rgb(243 244 246);
    }
    .completed {
        text-decoration: line-through;
        color: grey;
    }
    
    .animation {
        animation-duration: 0.3s;
    }
    
    .fade-enter-active, .fade-leave-active {
        transition: opacity .2s;
      }
    
    .fade-enter, .fade-leave-to {
    opacity: 0;
    }
    </style>