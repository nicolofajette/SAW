package com.example.nick.myemergency;

import android.content.ContentValues;
import android.content.Context;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteOpenHelper;
import android.util.Log;

import java.util.ArrayList;

public class MyEmergencyDB {

    // database constants
    public static final String DB_NAME = "myEmergency.db";
    public static final int    DB_VERSION = 1;

    // information table constants
    public static final String INFORMATION_TABLE = "information";

    public static final String INFORMATION_ID = "_id";
    public static final int    INFORMATION_ID_COL = 0;

    public static final String INFORMATION_NAME = "name";
    public static final int   INFORMATION_NAME_COL = 1;

    public static final String INFORMATION_SURNAME = "surname";
    public static final int   INFORMATION_SURNAME_COL = 2;

    public static final String INFORMATION_CF = "CF";
    public static final int   INFORMATION_CF_COL = 3;

    public static final String INFORMATION_ANNI = "anni";
    public static final int   INFORMATION_ANNI_COL = 4;

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


    // CREATE and DROP TABLE statements
    public static final String CREATE_INFORMATION_TABLE =
            "CREATE TABLE " + INFORMATION_TABLE + " (" +
                    INFORMATION_ID         + " INTEGER PRIMARY KEY AUTOINCREMENT, " +
                    INFORMATION_NAME    + " TEXT, " +
                    INFORMATION_SURNAME      + " TEXT, " +
                    INFORMATION_CF      + " TEXT, " +
                    INFORMATION_ANNI  + " TEXT, " +
                    INFORMATION_TELEPHONE     + " TEXT," +
                    INFORMATION_CONTACT1    + " TEXT," +
                    INFORMATION_CONTACT2    + " TEXT," +
                    INFORMATION_CANCEL  + " TEXT, " +
                    TASK_HIDDEN     + " TEXT)";

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

            // insert sample tasks
            db.execSQL("INSERT INTO information VALUES (1, 'Nicolò', 'Fajette', 'FJTNCL95R02D969Z', '21', '3336518727', '3929138750', '3316013558', '0', '0')");
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
                        cursor.getString(INFORMATION_ANNI_COL),
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

    public long insertInformation(Information information) {
        ContentValues cv = new ContentValues();
        cv.put(INFORMATION_NAME, information.getName());
        cv.put(INFORMATION_SURNAME, information.getSurname());
        cv.put(INFORMATION_CF, information.getCF());
        cv.put(INFORMATION_ANNI, information.getAnni());
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
        cv.put(INFORMATION_CF, information.getCF());
        cv.put(INFORMATION_ANNI, information.getAnni());
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

    public int deleteInformation(long id) {
        String where = INFORMATION_ID + "= ?";
        String[] whereArgs = { String.valueOf(id) };

        this.openWriteableDB();
        int rowCount = db.delete(INFORMATION_TABLE, where, whereArgs);
        this.closeDB();

        return rowCount;
    }
}
