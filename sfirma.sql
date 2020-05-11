CREATE TABLE hesla(
		ID			  INTEGER AUTO_INCREMENT,
		Login		  VARCHAR(10)  NOT NULL,
		Heslo		  VARCHAR(29) NOT NULL,
		JeAdmin		  BOOLEAN, 
		PRIMARY KEY(ID)
);
commit;
CREATE TABLE zakaznik (
        RC            VARCHAR(11) NOT NULL,
        Dulezitost    INTEGER,
        Jmeno		  VARCHAR(11) NOT NULL,
        Prijmeni	  VARCHAR(21) NOT NULL,
        Adresa		  VARCHAR(51) NOT NULL,
		fk_ID		  INTEGER NOT NULL,
		PRIMARY KEY(RC)
);
CREATE TABLE zakazka (
        ID            INTEGER AUTO_INCREMENT,
        Popis         VARCHAR(1000) NOT NULL,
		Stav		  INTEGER,
        fk_zakaznik   VARCHAR(11),
		PRIMARY KEY(ID)
);
CREATE TABLE pozadavek (
        ID         	  INTEGER AUTO_INCREMENT,
        Popis  		  VARCHAR(1000) NOT NULL,
        fk_osoba	  VARCHAR(11),
        fk_zakazka	  INTEGER,
		PRIMARY KEY(ID)

);
CREATE TABLE material (
        ID            INTEGER AUTO_INCREMENT,
        Cena    	  INTEGER NOT NULL,
        Typ       	  VARCHAR(21) NOT NULL,
        Mnozstvi	  INTEGER NOT NULL,
        fk_zakazka    INTEGER,
		PRIMARY KEY(ID)
);
CREATE TABLE externi_zamestnanec (
        RC            VARCHAR(11) NOT NULL,
        Hodnoceni     INTEGER,
        Mzda          INTEGER,
        Jmeno		  VARCHAR(11) NOT NULL,				
        Prijmeni	  VARCHAR(21) NOT NULL,
        Adresa		  VARCHAR(51) NOT NULL,
        fk_zakazka    INTEGER,
        fk_faktura    INTEGER,
		fk_ID		  INTEGER NOT NULL,
		PRIMARY KEY(RC)
);
CREATE TABLE zamestnanec (
        RC        	  VARCHAR(11) NOT NULL,
        Hodnoceni     INTEGER,
        Mzda          INTEGER NOT NULL,
        Jmeno		  VARCHAR(11) NOT NULL,				
        Prijmeni	  VARCHAR(21) NOT NULL,
        Adresa		  VARCHAR(51) NOT NULL,
        fk_faktura    INTEGER,
		fk_ID		  INTEGER NOT NULL,
		PRIMARY KEY(RC)
);
CREATE TABLE faktura(
		ID            	  INTEGER AUTO_INCREMENT,
        Hodnota_faktury   INTEGER NOT NULL,
        Datum_splatnosti  VARCHAR(20) NOT NULL,
        fk_zakazka        INTEGER,
		PRIMARY KEY(ID)
);
CREATE TABLE historie (
       ID            	INTEGER AUTO_INCREMENT,
       fk_zamestnanec  	VARCHAR(11),
       fk_zakazka      	INTEGER,
       PRIMARY KEY(ID)
); 
commit;

ALTER TABLE zakazka ADD CONSTRAINT fk1_RC FOREIGN KEY (fk_zakaznik) REFERENCES zakaznik(RC) ON DELETE SET NULL;
ALTER TABLE pozadavek ADD CONSTRAINT fk2_ID FOREIGN KEY (fk_zakazka) REFERENCES zakazka(ID) ON DELETE SET NULL;
ALTER TABLE pozadavek ADD CONSTRAINT fk3_RC FOREIGN KEY (fk_osoba) REFERENCES zakaznik(RC) ON DELETE SET NULL;
ALTER TABLE material ADD CONSTRAINT fk4_ID FOREIGN KEY (fk_zakazka) REFERENCES zakazka(ID) ON DELETE SET NULL;
ALTER TABLE externi_zamestnanec ADD CONSTRAINT fk5_ID FOREIGN KEY (fk_zakazka) REFERENCES zakazka(ID) ON DELETE SET NULL;
ALTER TABLE faktura ADD CONSTRAINT fk7_ID FOREIGN KEY (fk_zakazka) REFERENCES zakazka (ID) ON DELETE SET NULL;
ALTER TABLE externi_zamestnanec ADD CONSTRAINT fk8_ID FOREIGN KEY (fk_faktura) REFERENCES faktura(ID) ON DELETE SET NULL;
ALTER TABLE zamestnanec ADD CONSTRAINT fk9_ID FOREIGN KEY (fk_faktura) REFERENCES faktura(ID) ON DELETE SET NULL;
ALTER TABLE zakaznik ADD CONSTRAINT fk10_ID FOREIGN KEY (fk_ID) REFERENCES hesla(ID) ON DELETE SET NULL;
ALTER TABLE externi_zamestnanec ADD CONSTRAINT fk11_ID FOREIGN KEY (fk_ID) REFERENCES hesla(ID) ON DELETE SET NULL;
ALTER TABLE zamestnanec ADD CONSTRAINT fk12_ID FOREIGN KEY (fk_ID) REFERENCES hesla(ID) ON DELETE SET NULL;
ALTER TABLE historie ADD CONSTRAINT fk13_ID FOREIGN KEY (fk_zamestnanec) REFERENCES zamestnanec(RC) ON DELETE SET NULL;
ALTER TABLE historie ADD CONSTRAINT fk14_ID FOREIGN KEY (fk_zakazka) REFERENCES zakazka(ID) ON DELETE SET NULL;
commit;

INSERT INTO hesla (Login, Heslo, JeAdmin) VALUES ("admin", "admin", "1");
INSERT INTO hesla (Login, Heslo, JeAdmin) VALUES ("zak", "zak", "2");
INSERT INTO hesla (Login, Heslo, JeAdmin) VALUES ("zam", "zam", "3");
INSERT INTO zamestnanec (RC,Hodnoceni,Mzda,Jmeno,Prijmeni,Adresa,fk_ID) VALUES ("9007308475", "5", "25000", "Janci","Onen" , "horna 87", "3");
INSERT INTO zakaznik (RC,Jmeno,Prijmeni,Dulezitost,Adresa,fk_ID) VALUES ("9007308475", "Janci","Onen" ,"5", "horna 87", "2");
commit;