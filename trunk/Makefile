PACKAGE=liman
VERSION=0.1
DEPEND=*.php include/* include/tests/* design/* 
DISTDIR=/tmp
FILES=*.php include design
DROP=\
	$(DISTDIR)/$(PACKAGE)-$(VERSION)/test.php\
	$(DISTDIR)/$(PACKAGE)-$(VERSION)/include/tests\
	$(DISTDIR)/$(PACKAGE)-$(VERSION)/design/unittest.css\
	$(DISTDIR)/$(PACKAGE)-$(VERSION)/*/.svn
default:	dist
dist:		$(DISTDIR)/$(PACKAGE)-$(VERSION).tar.gz
$(DISTDIR)/$(PACKAGE)-$(VERSION).tar.gz: $(DEPEND) 
	mkdir -p $(DISTDIR)/$(PACKAGE)-$(VERSION)
	cp -r $(FILES) $(DISTDIR)/$(PACKAGE)-$(VERSION)
	rm -rf $(DROP)
	cd $(DISTDIR) && 	tar zcf $(DISTDIR)/$(PACKAGE)-$(VERSION).tar.gz 	$(PACKAGE)-$(VERSION)
	cd $(DISTDIR) &&	tar jcf $(DISTDIR)/$(PACKAGE)-$(VERSION).tar.bz2	$(PACKAGE)-$(VERSION)
	cd $(DISTDIR) && 	zip -r $(DISTDIR)/$(PACKAGE)-$(VERSION).zip 		$(PACKAGE)-$(VERSION)
	rm -rf $(DISTDIR)/$(PACKAGE)-$(VERSION)
	ls -l $(DISTDIR)/$(PACKAGE)-$(VERSION).*
clean:
	rm -rf $(DISTDIR)/$(PACKAGE)-*.*
