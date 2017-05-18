package com.example.nick.myemergency;


public class Problem {

    private long id;
    private String problem_name;

    public Problem() {
        problem_name = "";
    }

    public Problem(int id, String problem_name) {
        this.id = id;
        this.problem_name = problem_name;
    }

    public String getName() { return problem_name;};
}