#! /bin/sh
# Kleiner Hack um UTF-8 im Zusammenhang mit Doxygen und LaTeX nutzen zu können
doxygen Doxyfile
sed -i "s/\\\~{A}/�/g" doxygen/*.tex
