package com.mweb.ant;

import org.apache.tools.ant.BuildException;
import org.apache.tools.ant.taskdefs.JDBCTask;
import java.sql.DatabaseMetaData;
import java.sql.ResultSet;
import java.util.regex.Matcher;
import java.util.regex.Pattern;

public class DropDatabases extends JDBCTask {

    private String pattern;

    public void setPattern(String pattern) {
        this.pattern = pattern;
    }

    public void execute() throws BuildException {
        try {
            DatabaseMetaData md = this.getConnection().getMetaData();
            ResultSet databases = md.getCatalogs();
            while (databases.next()) {
                String databaseName = databases.getString("TABLE_CAT");
                Pattern p = Pattern.compile(this.pattern);
                Matcher m = p.matcher(databaseName);
                if (m.find()) {
                    log("dropping database: " + databaseName);
                    String sql = "drop database " + databaseName;
                    this.getConnection().createStatement().execute(sql);
                }

            }
        } catch (Exception e) {
            System.out.println(e.getMessage());
        }
    }
}
