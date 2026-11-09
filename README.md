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
   # git clone https://github.com/iesbillenguatges/intro_n.git
   # cd intro_n
   # php -S 0.0.0.0:80
   ```
2. Prova el port 80. Prova la app web amb 2 o 3 alumnes
3. En altra pertanya o terminal (fora del contenidor) fes:
   ```bash
   $ cat /intro_n/alumnes.json
   ``` 
   Ara pots vore el json amb les dades dels alumnes
