package com.example.nick.myemergency;

import org.xml.sax.Attributes;
import org.xml.sax.SAXException;
import org.xml.sax.helpers.DefaultHandler;


public class XMLHandler extends DefaultHandler{
    private long callId;

    private boolean isIdRequest = false;
    private boolean isUser = false;
    private boolean isNome = false;
    private boolean isCognome = false;
    private boolean isEmergenza = false;
    private boolean isLocalization = false;


    public long getCallStatus(){
        return callId;
    }

    public void startDocument() throws SAXException{

    }

    public void startElement(String namespaceURI, String localName, String qName, Attributes atts) throws SAXException{
        if(qName.equals("id_richiesta")){
            isIdRequest = true;
            return;
        }else if(qName.equals("utente")){
            isUser = true;
            return;
        }else if(qName.equals("nome")){
            isNome = true;
            return;
        }else if(qName.equals("cognome")){
            isCognome = true;
            return;
        }else if(qName.equals("emergenza")){
            isEmergenza = true;
            return;
        }else if(qName.equals("localizzazione")){
            isLocalization = true;
            return;
        }
    }

    public void characters(char ch[], int start, int lenght){
        String s = new String(ch, start, lenght);
        if(isIdRequest){
            callId = Long.parseLong(s);
            isIdRequest = false;
            return;
        }else if(isUser){

        }else if(isNome){

        }
    }

    public void endElement(String namespaceURI, String localName, String qName) throws SAXException{

    }
}
