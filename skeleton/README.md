# Bootiq Recruiting Test - Product Info Service

Implementace jednoduché služby pro poskytování informací o produktech vytvořená jako součást náborového úkolu pro Bootiq.  

Služba poskytuje endpoint, který vrací informace o produktu podle jeho ID. Primárním zdrojem dat je ElasticSearch, s automatickým fallbackem na MySQL v případě chyby.

## Klíčové vlastnosti

- **Kombinované vyhledávání**  
  Primárním zdrojem dat je ElasticSearch. Pokud není dostupný nebo dotaz selže, aplikace automaticky použije MySQL jako fallback.

- **Caching**  
  Výsledky dotazů jsou ukládány pomocí Symfony Cache, což snižuje počet volání externích providerů a zrychluje odezvu API.

- **Počítadlo přístupů k produktu**  
  Počet zobrazení produktu je ukládán do JSON souboru. Zápisy jsou chráněny pomocí `flock`, aby nedocházelo ke kolizím při souběžných požadavcích.

- **Testování**  
  Projekt obsahuje unit testy (Mockery) pro jednotlivé služby a API testy pomocí Codeception pro ověření endpointů.

---

## Instalace a konfigurace

### 1. Instalace závislostí

```bash
composer install
```

### 2. Nastavení prostředí

Vytvořit soubor `.env.test` (nebo upravit existující) a nastavit potřebné proměnné:

```env
DEFAULT_URI=http://localhost
FORCE_MYSQL=false
```

### 3. Spuštění aplikace

```bash
symfony serve
```

Aplikace bude dostupná na adrese:

```
http://localhost:8000/product-info/{id}
```

Příklad requestu:

```
GET /product-info/123
```

---

### Spouštění testů

Projekt používá framework **Codeception**.

#### Spuštění všech testů

```bash
vendor/bin/codecept run
```

#### Unit testy

Testují jednotlivé služby a komponenty izolovaně.

```bash
vendor/bin/codecept run Unit
```

#### API testy

Testují HTTP endpointy a správné fungování controlleru a routingu.

```bash
vendor/bin/codecept run Api
```

---

## Technické poznámky

- **Práce se soubory**   
  Ve třídě `FileProductQueryCounter` je použito zamykání souboru pomocí `flock`, které zajišťuje bezpečný zápis i při více paralelních požadavcích.  
  Pro čtení obsahu souboru je využito `stream_get_contents`, aby se předešlo problémům s PHP stat cache při práci s velikostí souboru.

- **Rozšiřitelnost**  
  Aplikace využívá `ProductDataProviderInterface`, díky čemuž lze jednoduše přidat nebo změnit zdroj dat (např. ElasticSearch, MySQL nebo jiný provider) bez zásahu do business logiky aplikace.

## Myšlenkový proces a postup

Při řešení jsem se snažil hlavně o to, aby aplikace byla jednoduchá, ale zároveň připravená na reálné použití.

Nejdřív jsem se zaměřil na oddělení jednotlivých zodpovědností. Proto jsem vytvořil rozhraní ProductDataProviderInterface, které definuje způsob, jak získat produkt podle ID. Díky tomu není zbytek aplikace závislý na konkrétní implementaci zdroje dat. V praxi to znamená, že ProductService vůbec neřeší, jestli data přichází z ElasticSearch nebo z MySQL.

ElasticSearch je použit jako primární zdroj, protože je typicky rychlejší pro vyhledávání. Zároveň jsem ale přidal fallback na MySQL, aby aplikace fungovala i v případě, že ElasticSearch není dostupný.

Další věc, na kterou jsem se zaměřil, byl caching. Pro cache jsem zvolil Symfony Cache komponentu, protože je přímo součástí Symfony ekosystému a umožňuje snadno změnit backend (například na Redis) bez změny aplikační logiky. Cache je použita proto, aby se minimalizoval počet dotazů na externí služby.

Součástí zadání bylo také počítání počtu dotazů na produkt. Implementoval jsem jednoduché řešení pomocí JSON souboru. Aby nedocházelo ke ztrátě dat při více současných requestech, použil jsem zamykání souboru pomocí flock(). Tím je zajištěno, že vždy zapisuje pouze jeden proces.

Nakonec jsem přidal unit testy pro jednotlivé služby a providery a functional test pro API endpoint, abych ověřil, že celý request flow funguje správně.

---
Autor: Štěpán Balatka
Datum: 6.3.2026



