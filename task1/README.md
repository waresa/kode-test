# Task 1
En enkelt microservice implementert i PHP. Microservicen skal kunne la brukeren lage, hente og paginate gjennom "posts". Slim Framework er brukt for å håndtere routing og HTTP requests og PDO for å kommunisere med databasen. Frontend er implementert med basic HTML, CSS og Javascript.

## Installasjon
1. Klon repoet
2. cd inn i task1 mappen
3. Kjør `composer install` for å installere dependencies
4. Kjør `php -S localhost:8080 -t public` for å starte serveren i root mappen

## Database (Oppgave 1)
1. Database tabellen for oppgave 1 fins i `task1\posts.sql`. For å koble til databasen må du endre `task1\src\Util\Database.php` med din egen database informasjon.
2. SQL for å lage databasen er i `task1\posts.sql`

## Bruk
1. Gå til `localhost:8080` for å se frontend
### POST (Oppgave 2)
1. Send en post request med `localhost:8080/api/posts` og en JSON body med `title` og `body` for å lage en post.
### GET (Oppgave 3 og 4)
1. Send en get request med `localhost:8080/api/posts/#` for å hente en post med id #.
2. Send en get request med `localhost:8080/api/posts?page=#&limit=#` for å hente en paginert liste med posts. `page` og `limit` er valgfrie parametere. Hvis de ikke er inkludert vil `page` defaulte til 1 og `limit` til 2.



