## Projekt zaliczeniowy z laboratorium "Programowanie aplikacji internetowych"

## Tematyka projektu: Aplikacja To-do list (Oblivia)

## Funkcjonalności i technologie:
- Wzorzec MVC,
- Uwierzytelnianie – logowanie, rejestracja i wylogowywanie użytkowników,
- Obsługa listy zadań dostępna tylko po zalogowaniu,
- Przypisanie list zadań do konkretnych użytkowników – zadania są powiązane z użytkownikiem przez klucz obcy (FK user_id),
- Zarządzanie zadaniami: (Wczytywanie listy zadań z bazy danych, Dodawanie nowych zadań, Usuwanie istniejących zadań, Oznaczanie zadań jako wykonane, Wszystkie operacje aktualizują dane w bazie na bieżąco),
- Eksport listy zadań jako pliku .json,
- Import listy zadań z pliku .json,
- Treść stron dostosowuje się w zależności od statusu użytkownika (zalogowany/niezalogowany),
- Zakładka "Profil" - Informacje o aktualnie zalogowanym użytkowniku,
- Formularze są walidowane po stronie zarówno klienta jak i serwera,
- Zasady bezpieczeństwa - Implementacja zgodna z praktykami omawianymi podczas laboratoriów,
- Komunikaty o błędach – informacyjne i intuicyjne,
- Responsywność interfejsu – aplikacja działa prawidłowo na różnych urządzeniach,
- Wykorzystanie sesji użytkownika - Dane logowania są przechowywane w sesjach
- Haszowanie haseł w bazie danych
-Projekt zgodny ze standardem HTML5/CSS3 - walidowane za pomocą w3c

## Wymagania
- XAMPP (MySQL Database, APACHE Web Server)
- PHP 8.2.12


## Uruchomienie
1. Pliki z katalogu "Projekt-Jan_Kowalski" należy umieścić w `XAMPP\htdocs`
2. Włączyć XAMPP MySQL Database oraz Apache Web Server
3. Zaimportować bazę danych do phpMyAdmin z pliku "projekt_php.sql"
4. Bazę danych można wypełnić rejestrując się lub poniższym poleceniem w phpmyadmin:
INSERT INTO `users` (`id`, `name`, `email`, `password`) VALUES (6, 'Tomek', 'tomek123@op.pl', '$2y$10$I2AWMBmENMTqkSC3cELgtegbJXI2BfUHahEnQttM5WenQT5M36O62');
5. Aplikację uruchomić otwierając plik "index.php" przez localhost

## Konta testowe
-   **Tomek**
    -   Login: tomek123@op.pl
    -   Hasło: tomek123