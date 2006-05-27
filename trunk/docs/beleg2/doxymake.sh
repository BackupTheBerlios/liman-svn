#! /bin/sh
# Kleiner Hack um UTF-8 im Zusammenhang mit Doxygen und LaTeX nutzen zu k√∂nnen
doxygen Doxyfile
sed -i "s/\\\~{A}/√/g" doxygen/*.tex
sed -i "s/Siehe auch:/Importiert:/g" doxygen/*.tex
