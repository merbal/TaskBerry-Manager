Projekt célja:
A projekt célja egy hatékony és könnyen kezelhető todo alkalmazás létrehozása, amely lehetővé teszi a felhasználók számára teendőik és feladataik kategorizálását, lekövetését és rendszerezését. Az alkalmazásnak egy olyan webes felülettel kell rendelkeznie, amelyet egy Raspberry Pi-n futó Apache szerveren, PHP alapú weblap szolgáltatással érhetnek el a felhasználók.

Funkcionalitás:

Felhasználókezelés: Regisztráció és bejelentkezés lehetősége a felhasználók számára, hogy egyéni fiókokkal rendelkezzenek, és személyes todo-listájukat kezelhessék.

Todo lista kezelése: A felhasználók létrehozhatnak, módosíthatnak és törölhetnek teendőket. A teendők címet, leírást, határidőt és kategóriát tartalmaznak.

Kategóriák: Lehetőség van teendők kategorizálására, hogy könnyen áttekinthető legyen a todo lista. Például: munka, otthon, személyes stb.

Feladatok kezelése: Az alkalmazás lehetővé teszi a felhasználók számára, hogy feladatokat rendeljenek hozzá teendőkhöz, és ezeket is lekövethessék.

Webes felület: A todo lista és felületek megjelenítése a felhasználók számára egy egyszerű, de hatékony webes felületen, amelyet a Raspberry Pi-n futó Apache szerveren és PHP alapon érhetnek el.

Adatbázis kezelés: A teendők és felhasználói adatok tárolása egy MariaDB adatbázisban a biztonság és az adatintegritás érdekében.

API szerver: Egy Python Flask alapú API szerver biztosítja az adatok elérést és kommunikációt a kliens (böngésző) és a szerver között. Az API JSON formátumban szolgáltatja az adatokat.

Böngésző alapú felhasználói élmény: A todo alkalmazás a böngészőn keresztül elérhető, és a frontend rész JavaScript segítségével generálja a dinamikus weboldalt, amely interaktív módon lehetővé teszi a felhasználók számára a todo lista kezelését.

Későbbi fejlesztés: Az alkalmazásnak későbbi fejlesztéseket is lehet támogatnia, például egy mobilalkalmazás készítését, amely lehetővé teszi a felhasználók számára, hogy teendőiket és feladataikat mobiltelefonjukról is kezeljék.

Ez a projekt célja és funkcionalitása lehetővé teszi a felhasználók számára egy hatékony todo alkalmazás használatát, amely könnyen integrálható és kibővíthető a jövőbeli igényekhez.
