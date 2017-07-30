package com.example.nick.myemergency;

import org.xml.sax.Attributes;
import org.xml.sax.SAXException;
import org.xml.sax.helpers.DefaultHandler;

import java.util.ArrayList;


public class XMLHandler extends DefaultHandler{
    private String status;
    private long callId;
    private String nome;
    private String cognome;
    private String nascita;
    private String codiceFiscale;
    private String cellulare;
    private String localization;
    private ArrayList<String> sintomi;

    private boolean isStatus = false;
    private boolean isIdRequest = false;
    private boolean isNome = false;
    private boolean isCognome = false;
    private boolean isNascita = false;
    private boolean isCodiceFiscale = false;
    private boolean isCellulare = false;
    private boolean isLocalization = false;
    private boolean isSintomi = false;
    private boolean isSintomo = false;


    public String getCallStatus(){
        return status;
    }

    public long getCallId(){
        return callId;
    }

    public void startDocument() throws SAXException{

    }

    public void startElement(String namespaceURI, String localName, String qName, Attributes atts) throws SAXException {
        if(qName.equals("status")){
            isStatus = true;
            return;
        }else if(qName.equals("id_richiesta")){
            isIdRequest = true;
            return;
        }else if(qName.equals("nome")){
            isNome = true;
            return;
        }else if(qName.equals("cognome")){
            isCognome = true;
            return;
        }else if(qName.equals("nascita")){
            isNascita = true;
            return;
        }else if(qName.equals("codiceFiscale")){
            isCodiceFiscale = true;
            return;
        }else if(qName.equals("cellulare")){
            isCellulare = true;
            return;
        }else if(qName.equals("localizzazione")){
            isLocalization = true;
            return;
        }else if(qName.equals("sintomi")){
            isSintomi = true;
            return;
        }else if(qName.equals("sintomo")){
            isSintomo = true;
            return;
        }
    }

    public void characters(char ch[], int start, int lenght){
        String s = new String(ch, start, lenght);
        if(isStatus){
            status = s;
            isStatus = false;
            return;
        }else if(isIdRequest){
            callId = Long.parseLong(s);
            isIdRequest = false;
            return;
        }else if(isNome){
            nome = s;
            isNome = false;
            return;
        }else if(isCognome){
            cognome = s;
            isCognome = false;
            return;
        }else if(isNascita){
            nascita = s;
            isNascita = false;
            return;
        }else if(isCodiceFiscale){
            codiceFiscale = s;
            isCodiceFiscale = false;
            return;
        }else if(isCellulare){
            cellulare = s;
            isCellulare = false;
            return;
        }else if(isLocalization) {
            localization = s;
            isLocalization = false;
            return;
        }else if(isSintomi){
            sintomi = new ArrayList<String>();
            isSintomi = false;
            return;
        }else if(isSintomo){
            sintomi.add(s);
            isSintomo = false;
            return;
        }
    }

    public void endElement(String namespaceURI, String localName, String qName) throws SAXException{

    }
}
