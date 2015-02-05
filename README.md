# ai-2-png-2-web
Illustrator workflow. Automatically generates PNG for each artboard in your AI file, and an HTML file for each PNG file. Each HTML file links to the next HTML file, last HTML files links to the first one.


## Requirements

MacOS X. No other OS tested, uses some MacOS-specific stuff.

Ghostscript. Used to convert your .ai file into PNG files — install via [Homebrew](http://brew.sh/):

``brew install ghostscript``

Optional: watchdog. Install via pip, which is included with Python. (No pip — [install it](https://pip.pypa.io/en/latest/installing.html).)

``pip install watchdog``


## Configuration

Configure by editing variables in Makefile.


## Run it

Make sure you have Ghostscript installed.

Clone or unzip Makefile and generate.php to the same folder where your AI file is located. In your Terminal/iTerm, change to this folder.

Change the value of ``ai`` variable to the name of your .ai file (index.ai is used by default).

Run:

``make stuff``

This will generate 2 folders:
``_png`` — which will have one PNG file per each artboard
``_out`` — HTML files, one per each PNG file

Names of the folders can be configured via Makefile variables (at the top of the Makefile)

``make clean``

Remove generated folders

## Watchdog task

``watchmedo shell-command --patterns="*.ai" --command="make stuff"``