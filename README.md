
# README - Aplikacja ToDo | L4yoos

ToDo App to aplikacja umożliwiająca efektywne zarządzanie codziennymi zadaniami, inspirując do organizacji czasu i zwiększania produktywności. Zaprojektowana z myślą o prostocie i intuicyjności, ToDo App oferuje użytkownikom elastyczne narzędzia do dodawania, edycji, oznaczania jako ukończone oraz usuwania zadań.

## Główne Funkcje

Dodawanie Zadań:

- Intuicyjne pole tekstowe umożliwia szybkie dodawanie nowych zadań do listy.

Edycja Zadań:

- Możliwość edycji tytułów zadań zapewnia elastyczność w zarządzaniu informacjami.

Oznaczanie jako Ukończone:

- Checkboxy pozwalają użytkownikom oznaczać zadania jako ukończone, ułatwiając śledzenie postępu.

Filtrowanie Zadań:

- Przyciski do filtrowania pozwalają użytkownikom wybierać między wszystkimi zadaniami, aktywnymi oraz ukończonymi.

Animacje i Efekty Wizualne:

- Wykorzystanie animacji przy dodawaniu i usuwaniu zadań wprowadza przyjemny aspekt wizualny.

Interakcja z API:

- Aplikacja komunikuje się z backendem za pomocą RESTful API, umożliwiając przechowywanie zadań na serwerze.
Responsywność i Prostota:

- Prosta, responsywna szata graficzna sprawia, że korzystanie z aplikacji jest łatwe zarówno na komputerze, jak i na urządzeniach mobilnych.
## Backend

#### Wykorzystane Frameworki:

- Symfony: Backend został stworzony w oparciu o framework Symfony, co zapewnia strukturę projektu oraz ułatwia zarządzanie encjami i routami.

- Doctrine: Do obsługi interakcji z bazą danych użyto Doctrine, co umożliwia łatwe mapowanie obiektowo-relacyjne i zarządzanie danymi.


## Endpointy API

Pobierz wszystkie zadania

- Endpoint: /api/
- Metoda: GET

Dodaj nowe zadanie

- Endpoint: /api/create
- Metoda: POST
- Ciało żądania: JSON z polami title (tytuł zadania) i completed (czy zadanie zakończone).

Aktualizuj zadanie

- Endpoint: /api/update/{id}
- Metody: PUT, PATCH
- Parametr: id - identyfikator zadania do zaktualizowania.
- Ciało żądania: JSON z polami title (nowy tytuł zadania) i completed (nowy status zakończenia zadania).

Usuń zadanie

- Endpoint: /api/delete/{id}
- Metoda: DELETE
- Parametr: id - identyfikator zadania do usunięcia.

## Obsługa błędów

- Błędny Content-Type: W przypadku nieprawidłowego nagłówka Content-Type, zwracany jest błąd 400 (Bad Request).

- Brak zadania o podanym ID: W przypadku próby aktualizacji lub usunięcia zadania o nieistniejącym ID, zwracany jest błąd 404 (Not Found).




## Frontend

#### Opis
Frontend aplikacji ToDo został zaimplementowany przy użyciu frameworka Vue.js. Dzięki temu użytkownik może dynamicznie zarządzać swoimi zadaniami, dodając, edytując, oznaczając jako ukończone lub usuwając je.

### Wykorzystane Frameworki
- Vue.js: Frontend został zbudowany w oparciu o framework Vue.js, co umożliwia łatwą reaktywność interfejsu użytkownika.

- Axios: Do komunikacji z backendem użyto biblioteki Axios, ułatwiającej wykonywanie asynchronicznych żądań HTTP.

### Funkcje Frontendu
- Dodawanie nowych zadań poprzez interaktywne pole tekstowe.
- Edycja istniejących zadań poprzez podwójne kliknięcie na tytuł zadania.
- Oznaczanie zadań jako ukończone poprzez zaznaczenie checkboxa.
- Usuwanie zadań poprzez kliknięcie na przycisk "X".
- Filtracja zadań według kategorii "All", "Active" i "Completed".


## Screenshots

![Screenshot](https://i.imgur.com/qMrGC4X.png)
![Screenshot](https://i.imgur.com/Ds4b79Y.png)


## Authors

- [@L4yoos](https://www.github.com/L4yoos)

