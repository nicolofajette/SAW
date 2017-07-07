package com.example.nick.myemergency;

public class Information {

    private long id;
    private String name;
    private String surname;
    private String codiceFiscale;
    private String date_of_birth;
    private String telephone;
    private String contact1;
    private String contact2;
    private String cancelDate;
    private String hidden;

    public static final String TRUE = "1";
    public static final String FALSE = "0";

    public Information() {
        name = "";
        surname = "";
        cancelDate = FALSE;
        hidden = FALSE;
    }

    public Information(String name, String surname, String codiceFiscale, String date_of_birth, String telephone, String contact1, String contact2, String cancel, String hidden) {
        this.name = name;
        this.surname = surname;
        this.codiceFiscale = codiceFiscale;
        this.date_of_birth = date_of_birth;
        this.telephone = telephone;
        this.contact1 = contact1;
        this.contact2 = contact2;
        this.cancelDate = cancel;
        this.hidden = hidden;
    }

    public Information(int id, String name, String surname, String codiceFiscale, String date_of_birth, String telephone, String contact1, String contact2, String cancel, String hidden) {
        this.id = id;
        this.name = name;
        this.surname = surname;
        this.codiceFiscale = codiceFiscale;
        this.date_of_birth = date_of_birth;
        this.telephone = telephone;
        this.contact1 = contact1;
        this.contact2 = contact2;
        this.cancelDate = cancel;
        this.hidden = hidden;

    }

    public void setId(long id) {
        this.id = id;
    }

    public long getId() {
        return id;
    }

    public void setName(String name) {
        this.name = name;
    }

    public String getName() {
        return name;
    }

    public void setSurname(String surname) {
        this.surname = surname;
    }

    public String getSurname() {
        return surname;
    }

    public void setCodiceFiscale(String codiceFiscale) { this.codiceFiscale = codiceFiscale; }

    public String getCodiceFiscale() { return codiceFiscale; }

    public void setDate_of_birth(String date_of_birth) {
        this.date_of_birth = date_of_birth;
    }

    public String getDate_of_birth() {
        return date_of_birth;
    }

    public void setTelephone(String telephone) {
        this.telephone = telephone;
    }

    public String getTelephone() {
        return telephone;
    }

    public void setContact1(String contact1) { this.contact1 = contact1; }

    public String getContact1() { return contact1; }

    public void setContact2(String contact2) { this.contact2 = contact2; }

    public String getContact2() { return contact2; }

    public String getCancelDate() {
        return cancelDate;
    }

    public long getCancelDateMillis() {
        return Long.parseLong(cancelDate);
    }

    public void setCancelDate(String cancelDate) {
        this.cancelDate = cancelDate;
    }

    public void setCancelDate(long millis) {
        this.cancelDate = Long.toString(millis);
    }

    public String getHidden(){
        return hidden;
    }

    public void setHidden(String hidden) {
        this.hidden = hidden;
    }


    @Override
    public String toString() {
        return name+" "+surname;   // used for print contacts
    }
}

