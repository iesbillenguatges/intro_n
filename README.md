# Introducció al núvol

Aquest és un repositori d'introducció creat pel departament de llenguatges de l'IES Biel Martí, dissenyat per a fer les primeres passes amb el llenguatge de programació PHP.

## Què fa aquest projecte?

El projecte conté una estructura web mínima en PHP (actualment formada per un fitxer principal `index.php`). El seu objectiu és servir com a plantilla base o codi d'exemple inicial per a:
* Comprovar que l'entorn de servidor web funciona correctament.
* Executar codi PHP bàsic al navegador.

## Requisits previs

Per a poder desplegar i executar aquest projecte necessites un entorn local que suporte PHP. Pots utilitzar qualsevol d'aquestes opcions:
* **XAMPP / WampServer / MAMP**: Paquets tot en un que inclouen Apache i PHP.
* **Docker**: Si prefereixes utilitzar contenidors.
* **PHP CLI**: El servidor intern que inclou el propi intèrpret de PHP.

## Com desplegar-lo

Tria un dels següents mètodes per a posar-lo en marxa:

### Mètode 1: Utilitzant el servidor intern de PHP (El més ràpid)

1. Clona el repositori a la teua màquina local:
   ```bash
   git clone https://github.com
   ```
2. Accedeix a la carpeta del projecte:
   ```bash
   cd intro_n
   ```
3. Inicia el servidor de proves de PHP en el port 8000:
   ```bash
   php -S localhost:8080
   ```
4. Obre el teu navegador web i visita: `http://localhost:8080`

