package com.example.nick.myemergency;

import android.content.ContentValues;
import android.content.Context;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteOpenHelper;
import android.util.Log;

import java.util.ArrayList;
import java.util.HashMap;

public class MyEmergencyDB {

    // database constants
    public static final String DB_NAME = "myEmergency.db";
    public static final int    DB_VERSION = 1;

    // information table constants
    public static final String INFORMATION_TABLE = "information";

    public static final String INFORMATION_ID = "id_i";
    public static final int    INFORMATION_ID_COL = 0;

    public static final String INFORMATION_NAME = "name";
    public static final int   INFORMATION_NAME_COL = 1;

    public static final String INFORMATION_SURNAME = "surname";
    public static final int   INFORMATION_SURNAME_COL = 2;

    public static final String INFORMATION_CF = "CF";
    public static final int   INFORMATION_CF_COL = 3;

    public static final String INFORMATION_DATE_OF_BIRTH = "date_of_birth";
    public static final int   INFORMATION_DATE_OF_BIRTH_COL = 4;

    public static final String INFORMATION_TELEPHONE = "telephone";
    public static final int   INFORMATION_TELEPHONE_COL = 5;

    public static final String INFORMATION_CONTACT1 = "contact1";
    public static final int   INFORMATION_CONTACT1_COL = 6;

    public static final String INFORMATION_CONTACT2 = "contact2";
    public static final int   INFORMATION_CONTACT2_COL = 7;

    public static final String INFORMATION_CANCEL = "date_cancel";
    public static final int    INFORMATION_CANCEL_COL = 8;

    public static final String TASK_HIDDEN = "hidden";
    public static final int    TASK_HIDDEN_COL = 9;

    //problems table constants
    public static final String PROBLEMS_TABLE = "problems";

    public static final String PROBLEMS_ID = "id_p";
    public static final int    PROBLEMS_ID_COL = 0;

    public static final String PROBLEMS_NAME ="problem_name";
    public static final int    PROBLEMS_NAME_COL = 1;

    //event table constants
    public static final String EVENT_TABLE = "events";

    public static final String EVENT_ID = "id_e";
    public static final int    EVENT_ID_COL = 0;

    public static final String EVENT_PERSON ="event_person";
    public static final int    EVENT_PERSON_COL = 1;

    public static final String EVENT_TYPE ="event_type";
    public static final int    EVENT_TYPE_COL = 2;

    public static final String EVENT_TIME ="event_time";
    public static final int    EVENT_TIME_COL = 3;

    // CREATE and DROP TABLE statements
    public static final String CREATE_INFORMATION_TABLE =
            "CREATE TABLE " + INFORMATION_TABLE + " (" +
                    INFORMATION_ID         + " INTEGER PRIMARY KEY AUTOINCREMENT, " +
                    INFORMATION_NAME    + " TEXT, " +
                    INFORMATION_SURNAME      + " TEXT, " +
                    INFORMATION_CF      + " TEXT, " +
                    INFORMATION_DATE_OF_BIRTH  + " TEXT, " +
                    INFORMATION_TELEPHONE     + " TEXT," +
                    INFORMATION_CONTACT1    + " TEXT," +
                    INFORMATION_CONTACT2    + " TEXT," +
                    INFORMATION_CANCEL  + " TEXT, " +
                    TASK_HIDDEN     + " TEXT)";

    public static final String CREATE_EVENT_TABLE =
            "CREATE TABLE " + EVENT_TABLE + " (" +
                    EVENT_ID         + " INTEGER PRIMARY KEY AUTOINCREMENT, " +
                    EVENT_TYPE      + " TEXT, " +
                    EVENT_PERSON     + " TEXT, " +
                    EVENT_TIME       + " TEXT)";

    public static final String CREATE_PROBLEMS_TABLE =
            "CREATE TABLE " + PROBLEMS_TABLE + " (" +
                    PROBLEMS_ID         + " INTEGER PRIMARY KEY AUTOINCREMENT, " +
                    PROBLEMS_NAME       + " TEXT)";

    public static final String DROP_INFORMATION_TABLE =
            "DROP TABLE IF EXISTS " + INFORMATION_TABLE;


    private static class DBHelper extends SQLiteOpenHelper {

        public DBHelper(Context context, String name,
                        SQLiteDatabase.CursorFactory factory, int version) {
            super(context, name, factory, version);
        }

        @Override
        public void onCreate(SQLiteDatabase db) {
            // create tables
            db.execSQL(CREATE_INFORMATION_TABLE);
            db.execSQL(CREATE_PROBLEMS_TABLE);
            db.execSQL(CREATE_EVENT_TABLE);

            // insert problems
            db.execSQL("INSERT INTO problems VALUES (1, 'infarto')");
            db.execSQL("INSERT INTO problems VALUES (2, 'non respira')");
            db.execSQL("INSERT INTO problems VALUES (3, 'non cosciente')");
            db.execSQL("INSERT INTO problems VALUES (4, 'non risponde')");
            db.execSQL("INSERT INTO problems VALUES (5, 'emorragia')");
            db.execSQL("INSERT INTO problems VALUES (6, 'ustione')");
            db.execSQL("INSERT INTO problems VALUES (7, 'frattura')");
            db.execSQL("INSERT INTO problems VALUES (8, 'incidente stradale')");
            db.execSQL("INSERT INTO problems VALUES (9, 'incidente sul lavoro')");
            db.execSQL("INSERT INTO problems VALUES (10, 'incidente casalingo')");
        }

        @Override
        public void onUpgrade(SQLiteDatabase db,
                              int oldVersion, int newVersion) {

            Log.d("Information", "Upgrading db from version "
                    + oldVersion + " to " + newVersion);

            Log.d("Task list", "Deleting all data!");
            db.execSQL(MyEmergencyDB.DROP_INFORMATION_TABLE);
            onCreate(db);
        }
    }

    // database object and database helper object
    private SQLiteDatabase db;
    private DBHelper dbHelper;

    // constructor
    public MyEmergencyDB(Context context) {
        dbHelper = new DBHelper(context, DB_NAME, null, DB_VERSION);
    }

    // private methods
    private void openReadableDB() {
        db = dbHelper.getReadableDatabase();
    }

    private void openWriteableDB() {
        db = dbHelper.getWritableDatabase();
    }

    private void closeDB() {
        if (db != null)
            db.close();
    }


    // public methods
    //Usato per la stampa nella activity principale
    public ArrayList<Information> getInformations() {
        String where =
                TASK_HIDDEN + "!='1'";

        ArrayList<Information> informations = new ArrayList<Information>();
        openReadableDB();
        Cursor cursor = db.query(INFORMATION_TABLE,
                null, where, null, null, null, null);
        while (cursor.moveToNext()) {
            informations.add(getInformationFromCursor(cursor));
        }
        cursor.close();
        closeDB();
        return informations;
    }

    public Information getInformation(long id) {
        String where = INFORMATION_ID + "= ?";
        String[] whereArgs = { Long.toString(id) };

        // handle exceptions?
        this.openReadableDB();
        Cursor cursor = db.query(INFORMATION_TABLE,
                null, where, whereArgs, null, null, null);
        cursor.moveToFirst();
        Information information = getInformationFromCursor(cursor);
        if (cursor != null)
            cursor.close();
        this.closeDB();

        return information;
    }

    private static Information getInformationFromCursor(Cursor cursor) {
        if (cursor == null || cursor.getCount() == 0){
            return null;
        }
        else {
            try {
                Information information = new Information(
                        cursor.getInt(INFORMATION_ID_COL),
                        cursor.getString(INFORMATION_NAME_COL),
                        cursor.getString(INFORMATION_SURNAME_COL),
                        cursor.getString(INFORMATION_CF_COL),
                        cursor.getString(INFORMATION_DATE_OF_BIRTH_COL),
                        cursor.getString(INFORMATION_TELEPHONE_COL),
                        cursor.getString(INFORMATION_CONTACT1_COL),
                        cursor.getString(INFORMATION_CONTACT2_COL),
                        cursor.getString(INFORMATION_CANCEL_COL),
                        cursor.getString(TASK_HIDDEN_COL));
                return information;
            }
            catch(Exception e) {
                return null;
            }
        }
    }

    public ArrayList<Problem> getProblems() {
        ArrayList<Problem> problems = new ArrayList<Problem>();
        openReadableDB();
        Cursor  cursor = db.rawQuery("SELECT * FROM problems",null);
        while (cursor.moveToNext()) {
            problems.add(getProblemFromCursor(cursor));
        }
        cursor.close();
        closeDB();
        return problems;
    }

    private static Problem getProblemFromCursor(Cursor cursor) {
        if (cursor == null || cursor.getCount() == 0){
            return null;
        }
        else {
            try {
                Problem problem = new Problem(
                        cursor.getInt(PROBLEMS_ID_COL),
                        cursor.getString(PROBLEMS_NAME_COL));
                return problem;
            }
            catch(Exception e) {
                return null;
            }
        }
    }


    public long insertInformation(Information information) {
        ContentValues cv = new ContentValues();
        cv.put(INFORMATION_NAME, information.getName());
        cv.put(INFORMATION_SURNAME, information.getSurname());
        cv.put(INFORMATION_CF, information.getCodiceFiscale());
        cv.put(INFORMATION_DATE_OF_BIRTH, information.getDate_of_birth());
        cv.put(INFORMATION_TELEPHONE, information.getTelephone());
        cv.put(INFORMATION_CONTACT1, information.getContact1());
        cv.put(INFORMATION_CONTACT2, information.getContact2());
        cv.put(INFORMATION_CANCEL, information.getCancelDate());
        cv.put(TASK_HIDDEN, information.getHidden());

        this.openWriteableDB();
        long rowID = db.insert(INFORMATION_TABLE, null, cv);
        this.closeDB();

        return rowID;
    }

    public int updateInformation(Information information) {
        ContentValues cv = new ContentValues();
        cv.put(INFORMATION_NAME, information.getName());
        cv.put(INFORMATION_SURNAME, information.getSurname());
        cv.put(INFORMATION_CF, information.getCodiceFiscale());
        cv.put(INFORMATION_DATE_OF_BIRTH , information.getDate_of_birth());
        cv.put(INFORMATION_TELEPHONE, information.getTelephone());
        cv.put(INFORMATION_CONTACT1, information.getContact1());
        cv.put(INFORMATION_CONTACT2, information.getContact2());
        cv.put(INFORMATION_CANCEL, information.getCancelDate());
        cv.put(TASK_HIDDEN, information.getHidden());

        String where = INFORMATION_ID + "= ?";
        String[] whereArgs = { String.valueOf(information.getId()) };

        this.openWriteableDB();
        int rowCount = db.update(INFORMATION_TABLE, cv, where, whereArgs);
        this.closeDB();

        return rowCount;
    }

    public int deleteInformation(Information information) {
        String where = INFORMATION_ID + "= ?";
        String[] whereArgs = { String.valueOf(information.getId()) };

        this.openWriteableDB();
        int rowCount = db.delete(INFORMATION_TABLE, where, whereArgs);
        this.closeDB();

        return rowCount;
    }

    public boolean testNotEmpty() {
        openReadableDB();
        Cursor cursor = db.query(INFORMATION_TABLE,
                null, null, null, null, null, null);
        if (cursor == null || cursor.getCount() == 0) {
            return false;
        } else {
            return true;
        }
    }

    public ArrayList<Evento> getEvents() {
        ArrayList<Evento> events = new ArrayList<Evento>();
        openReadableDB();
        Cursor  cursor = db.rawQuery("SELECT * FROM events",null);
        while (cursor.moveToNext()) {
            events.add(getEventFromCursor(cursor));
        }
        cursor.close();
        closeDB();
        return events;
    }

    private static Evento getEventFromCursor(Cursor cursor) {
        if (cursor == null || cursor.getCount() == 0){
            return null;
        }
        else {
            try {
                Evento event = new Evento(
                        cursor.getInt(EVENT_ID_COL),
                        cursor.getString(EVENT_PERSON_COL),
                        cursor.getString(EVENT_TYPE_COL),
                        cursor.getString(EVENT_TIME_COL));
                return event;
            }
            catch(Exception e) {
                return null;
            }
        }
    }

    public long insertEvent(Evento event) {
        ContentValues cv = new ContentValues();
        cv.put(EVENT_PERSON, event.getName());
        cv.put(EVENT_TYPE, event.getType());
        cv.put(EVENT_TIME, event.getTime());

        this.openWriteableDB();
        long rowID = db.insert(EVENT_TABLE, null, cv);
        this.closeDB();

        return rowID;
    }

    public void deleteEvents() {
        openReadableDB();
        db.execSQL("DELETE FROM "+ EVENT_TABLE);
        closeDB();
    }

}
