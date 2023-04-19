# exchange_rates by Mateusz Rejnowicz
API prostego systemu do zapisywania kursu walut.
Obsługiwana jest autoryzacja, po zarejestrowaniu i zalogowaniu się mamy dostęp do wszystkich możliwych opcji, takich jak dodanie kursu walut, wyświetlenie kursów walut z danego dnia, wyświetlenie kursów walut tylko z wybranej waluty, wyświetlenie kursów walut z danego dnia i danej waluty.
Po poprawnym zalogowaniu otrzymujesz token potrzebny do dalszych działań. API testowane w POSTMAN

REJESTRACJA I LOGOWANIE:
Do rejestracji:
name,email,password, oraz role}'admin,user'

Do logowania:
email,password

Po zalogowaniu otrzymasz token 

Poruszanie sie po bazie:

currency|'EUR,GBP,USD'  =>EUR
date|'format:Y-m-d'     =>2023-12-12  
amount|numeric          =>4.22

Nazwa bazy danych: exchange_rates
