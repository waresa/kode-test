# Task 2
## Oppgave a. 
Please arrange the loops after how fast they will run under PHP 7.1. If the dataset $array
has about 1000000 int elements.

## Svar:
1. B > A = C > D
2. Har også kjørt benchmark test for å bekrefte resultatet. Benchmarken og resultatet er i `task2\benchmark.php`

### B
Loop B er den Raskeste. Grunnen til dette er det at Foreach loop er mer optimisert i php 7.1. Andre grunner kan vær at foreach loopen har også ikke en teller som må oppdateres hver gang loopen kjører, den oppdatere verdien til nåværende element direkte i en variabel som i dette tilfellet er $nr. Dette simplifiserer loopen og redusere overhead som øker hastigheten. Et annet grunn er det at med foreach loopen blir verdien til elementer i arrayen hentet direkte mens i for loops blir de hentet via bruk av indexen til elementet. Dette kan også vær med på å øke hastigheten til foreach loopen.

```php
foreach ($array as $nr) {
echo "[".$nr."]";
}
```

### A og C
Loop A og C er de raskeste etter B. Begge loopene kjører count() bare en gang før starten av loopen. Loop A kjører count($array) en gang og lagrer resultatet i variabelen $ant. Den variablen brukes i conditionen av loopen. Loop C kjører count($array) også engang og lagrer resultatet i variablen $ant men i initialisering delen av for loopen. Dette er den eneste forskjellen mellom loop A og C men skal ikke ha noen effekt på hastigheten. Om det er noe hastighet forskjell mellom loop A og C er det veldig lite og kan være tilfeldig.

```php
// ---- A -----------------------------------------
$ant = count($array);
for ($i = 0 ; $i<$ant; $i++) {
echo "[".$array[$i]."]";
}

// ---- C -----------------------------------------
for ($i = 0, $ant = count($array) ; $i<$ant; $i++) {
echo "[".$array[$i]."]";
}
```
### D
Loop D er den tregeste ut av alle. Grunnen er at den kjører count($array) hver gang loopen kjører som ødelegger ytelsen. 

```php
// ---- D -----------------------------------------
for ($i = 0 ; $i<count($array); $i++) {
echo "[".$array[$i]."]";
}
```

## Oppgave b. 
What happens to the four loops if a dataset is empty, $array = NULL;

### Svar:
1. Loop A, C og Dvil ikke kjøre fordi count($array) vil returnere 0 og conditionen $i<$ant i loopen vil være false. Det er fordi $i = 0 og $ant er også 0. Loopenes overhead vil fortsatt kjøre.
2. Når det kommer til Loop B så skjer det ingen iterasjoner siden arrayen er tom. Loopenes overhead vil fortsatt kjøre som de andre loopene. I foreach loopen vil du også få en warning om at argumentet er ikke en valid. Men den kaster ikke en error.