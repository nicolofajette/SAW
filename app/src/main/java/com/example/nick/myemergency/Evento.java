package com.example.nick.myemergency;


public class Evento {

        private long id;
        private String type;
        private String name;
        private String time;

        public Evento() {
            name = "";
            type = "";
            time = "";
        }

        public Evento(String type, String name, String time) {
            this.type = type;
            this.name = name;
            this.time = time;
        }

        public Evento(int id, String type, String name, String time) {
            this.id = id;
            this.name = name;
            this.type = type;
            this.time = time;
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

        public void setType(String type) {
            this.type = type;
        }

        public String getType() {
            return type;
        }

        public void setTime(String time) { this.time = time; }

        public String getTime() { return time; }


        @Override
        public String toString() {
            return name+" "+type+" "+time;   // used for print contacts
        }
}

