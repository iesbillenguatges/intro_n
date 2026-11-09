# Introducció al núvol públic

Aquest és un repositori del mòdul d'introducció al núvol públic, dissenyat per a provar la persistència de dades en màquines virtuals al núvol.

## Què fa aquest projecte?

El projecte conté una estructura web mínima en PHP (actualment formada per un fitxer principal `index.php`). El seu objectiu és servir com a plantilla base o codi d'exemple inicial per a:
* Comprovar que l'entorn de servidor web funciona correctament.
* Executar codi PHP bàsic al navegador.
* Tenir persistència de dades

## Requisits previs

Per a poder desplegar i executar aquest projecte necessites un entorn local que suporte PHP. Pots utilitzar qualsevol d'aquestes opcions:
* **XAMPP / WampServer / MAMP**: Paquets tot en un que inclouen Apache i PHP.
* **Docker**: Si prefereixes utilitzar contenidors.

## Com desplegar-lo

Tria una màquina virtual en killercoda, codespaces o google cloud shell

1. Clona el repositori a la teua màquina local:
   ```bash
   git clone 
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

