# Introducció al núvol públic

Aquest és un repositori del mòdul d'introducció al núvol públic, dissenyat per a provar la persistència de dades en màquines virtuals al núvol.

## Què fa aquest projecte?

El projecte conté una estructura web mínima en PHP (actualment formada per un fitxer principal `index.php`). El seu objectiu és servir com a plantilla base o codi d'exemple inicial per a:
* Comprovar que l'entorn de servidor web funciona correctament.
* Executar codi PHP bàsic al navegador.
* Tenir persistència de dades

## Requisits previs

Per a poder desplegar i executar aquest projecte pots utilitzar qualsevol d'aquestes opcions: una màquina virtual en killercoda, codespaces o google cloud shell.

1. Llança un contenidor de docker amb una unitat virtual
   ```bash
   mkdir intro_n
   $ docker run -it --name Intro_n -v /intro_n:/intro_n -p80:80 alpine
   # apk add git php
   git clone 
   ```
2. Clona el repositori a la teua màquina local:
   ```bash
   git clone https://github.com/iesbillenguatges/intro_n.git
   ```
3. Accedeix a la carpeta del projecte:
   ```bash
   cd intro_n
   ```
3. Inicia el servidor de proves de PHP en el port 8000:
   ```bash
   php -S localhost:8080
   ```
4. Obre el teu navegador web i visita: `http://localhost:8080`

