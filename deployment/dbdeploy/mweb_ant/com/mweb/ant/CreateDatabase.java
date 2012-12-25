package com.mweb.ant;

import org.apache.tools.ant.BuildException;
import org.apache.tools.ant.taskdefs.JDBCTask;
import java.sql.ResultSet;

public class CreateDatabase extends JDBCTask {

    private String databaseName;

    public void setDatabaseName(String databaseName) {
        this.databaseName = databaseName;
    }

    public void execute() throws BuildException {
        try {
            log("create database: " + this.databaseName);
            String sql = "CREATE DATABASE IF NOT EXISTS " + this.databaseName; 
            this.getConnection().createStatement().execute(sql);
        } catch (Exception e) {
            System.out.println(e.getMessage());
        }
    }
}
