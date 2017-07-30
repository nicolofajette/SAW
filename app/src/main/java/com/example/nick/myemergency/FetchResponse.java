package com.example.nick.myemergency;

import android.content.Context;
import android.os.AsyncTask;
import android.util.Log;
import android.widget.Toast;

import org.xml.sax.InputSource;
import org.xml.sax.XMLReader;

import java.io.FileInputStream;

import javax.xml.parsers.SAXParser;
import javax.xml.parsers.SAXParserFactory;



public class FetchResponse extends AsyncTask<String, Void, String>{
    private Context context;

    public FetchResponse(Context context){
        this.context = context;
    }

    @Override
    protected String doInBackground(String... params){
        String filename = params[0];
        try{
            SAXParserFactory factory = SAXParserFactory.newInstance();
            SAXParser parser = factory.newSAXParser();
            XMLReader xmlReader = parser.getXMLReader();

            XMLHandler xmlHandler = new XMLHandler();
            xmlReader.setContentHandler(xmlHandler);

            FileInputStream in = context.openFileInput(filename);

            InputSource is = new InputSource(in);
            xmlReader.parse(is);
            if(xmlHandler.getCallStatus() == "Error"){
                //Errore nella richiesta
                return "Request error";
            }else{
                return String.valueOf(xmlHandler.getCallId());
            }
        }catch(Exception e){
            Log.e("Parsing XML", e.toString());
            return "Parse error";
        }
    }

    @Override
    protected void onPostExecute(String result){
        if(result.equals("Request error")){
            //Errore
        }else if(result.equals("Parse error")){
            //Errore
        }else{
            //Successo
            Toast.makeText(context, "Richiesta inviata", Toast.LENGTH_LONG);
            //TODO: inserire qui inserimento evento: richiesta ricevuta dal server con id result
        }
    }
}
