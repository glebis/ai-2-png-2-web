ai = index.ai
png_output = _png
output_folder = _out
img_folder = img
resolution = 144

number_format = 2


localdir     = /Users/
remoteuser   = root
remotehost   = 192.168.0.1
remotedir    = /srv/www/happyclient

switches     = -zavP
putswitches  = --exclude "logs"
putmessage   = Updating server with newer files from local site mirror...


# - See more at: http://blog.ianty.com/general-development/simple-deployments-made-easy-using-rsync-with-a-makefile/#sthash.QwcnZEG1.dpuf

stuff: png html
sync:    put
all: stuff sync

sd = $(patsubst %/,%,$(tdir))
OS := $(shell uname)

put:
	@echo "$(putmessage)"
	rsync $(putswitches) $(switches) $(output_folder)$(sd)/ $(remoteuser)@$(remotehost):$(remotedir)$(sd)/
	@echo
	@afplay -v .1 /System/Library/Sounds/Tink.aiff

clean:
	@rm -r $(png_output)
	@rm -r $(output_folder)

png:
	command -v gsc >/dev/null 2>&1 || { echo "Converting AI/PDF to PNG requires GhostScript. Install it: brew install ghostscript" >&2; exit 1; }
	mkdir -p $(png_output)
	gsc  -dBATCH -dNOPAUSE -sDEVICE=pngalpha -r$(resolution) -sOutputFile=$(png_output)/%0$(number_format)d.png $(ai)

html:
	command -v php >/dev/null 2>&1 || { echo "PHP should be installed for this command to run." >&2; exit 1; }
	@mkdir -p $(output_folder)
	@cp -rf $(png_output) $(output_folder)/$(img_folder)
	@php generate.php --output_folder=$(output_folder)  --img_folder=$(img_folder)


watch:
	@command -v watchmedo >/dev/null 2>&1 || { echo "Watchdog is required for this command to run. Install it: pip install watchdog" >&2; exit 1; }
	watchmedo shell-command --drop --patterns="*.ai" --command='make stuff'

.PHONY: sync clean png html all stuff