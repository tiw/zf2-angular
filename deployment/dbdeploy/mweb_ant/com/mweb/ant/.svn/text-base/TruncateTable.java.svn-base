package com.mweb.ant;

import org.apache.tools.ant.BuildException;
import org.apache.tools.ant.taskdefs.JDBCTask;
import java.sql.DatabaseMetaData;
import java.sql.ResultSet;

public class TruncateTable extends JDBCTask {

    private String blacklist;

    public void setBlacklist(String blacklist) {
        this.blacklist = blacklist;
    }

    public void execute() throws BuildException {
        try {
            DatabaseMetaData md = this.getConnection().getMetaData();
            ResultSet rs = md.getTables(null, null, "%", null);
            while (rs.next()) {
                String tableName = rs.getString(3);
                if (!tableName.equals(this.blacklist)) {
                    log("truncating table: " + rs.getString(3));
                    String sql = "truncate table " + tableName;
                    this.getConnection().createStatement().execute(sql);
                }
            }
        } catch (Exception e) {
            System.out.println(e.getMessage());
        }
    }
}
