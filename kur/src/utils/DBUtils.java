package utils;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.List;

import beans.Admin;
import beans.Clients;
import beans.Product;
import beans.UserAccount;

public class DBUtils {

    public static UserAccount findUser(Connection conn, //
                                       String userLogin, String userPassword) throws SQLException {

        String sql = "SELECT login,password FROM authorization WHERE login = " + "'" + userLogin + "'" + " AND password = " + "'" + userPassword + "'";

        PreparedStatement preparedStatement = conn.prepareStatement(sql);

        ResultSet rs = preparedStatement.executeQuery();

        if (rs.next()) {
            String login = rs.getString("login");
            String password = rs.getString("password");

            UserAccount user = new UserAccount(login,password);

            return user;
        }
        return null;
    }

    public static Admin findAdmin(Connection conn, //
                                       String adminLogin, String adminPassword) throws SQLException {

        String sql = "SELECT login,password FROM admin WHERE login = " + "'" + adminLogin + "'" + " AND password = " + "'" + adminPassword + "'";

        PreparedStatement preparedStatement = conn.prepareStatement(sql);
        ResultSet rs = preparedStatement.executeQuery();

        if (rs.next()) {
            String login = rs.getString("login");
            String password = rs.getString("password");
            System.out.println(login + " " + password);
            Admin admin = new Admin(login,password);

            return admin;
        }

        return null;
    }

    public static UserAccount findUser(Connection conn, String adminLogin) throws SQLException {

        String sql = "SELECT login FROM authorization WHERE login = " + "'" + adminLogin + "'";

        PreparedStatement pstm = conn.prepareStatement(sql);
        ResultSet rs = pstm.executeQuery();

        if (rs.next()) {
            String password = rs.getString("Password");

            UserAccount user = new UserAccount();

            return user;
        }
        return null;
    }

    public static List<Product> queryProduct(Connection conn) throws SQLException {
        String sql = "SELECT id_product,type,brand,name_pr,quantity,rating,cost FROM products";

        PreparedStatement pstm = conn.prepareStatement(sql);

        ResultSet rs = pstm.executeQuery();
        List<Product> list = new ArrayList();
        while (rs.next()) {
            int id_product = rs.getInt("id_product");
            String type = rs.getString("type");
            String brand = rs.getString("brand");
            String name_pr = rs.getString("name_pr");
            int quantity = rs.getInt("quantity");
            int rating = rs.getInt("rating");
            float cost = rs.getFloat("cost");

            Product product = new Product(id_product,type,brand,name_pr,quantity,rating,cost);

            list.add(product);
        }
        for (Product product:list) {
            System.out.println(product);
        }
        return list;
    }

    // Поиск продукта по номеру
    public static Product findProduct(Connection conn, String id_product) throws SQLException {
        String sql = "SELECT quantity,cost FROM products WHERE id_product = " + "'" + id_product + "'";
        PreparedStatement pstm = conn.prepareStatement(sql);
        ResultSet rs = pstm.executeQuery();

        while (rs.next()) {
            int quantity = rs.getInt("quantity");
            float cost = rs.getFloat("cost");
            return new Product(quantity, cost);
        }
        return null;
    }

    // Редактирование продукта
    public static void updateProduct(Connection conn,String id_product,String quantity,String cost) throws SQLException {
        try {
            String sql = "UPDATE products SET quantity = " + quantity + " ,cost = " + cost + " WHERE id_product = " + id_product;
            System.out.println(sql);
            PreparedStatement pstm = conn.prepareStatement(sql);
            pstm.executeUpdate();
        } catch (SQLException e) {
            System.out.println(e);
        }
    }

    // Добавление продукта
    public static void insertProduct(Connection conn, Product product) throws SQLException {
        String sql = "INSERT INTO products (type, brand, name_pr, quantity,cost) VALUES (?,?,?,?,?)";

        PreparedStatement pstm = conn.prepareStatement(sql);

        pstm.setString(1,product.getType());
        pstm.setString(2,product.getBrand());
        pstm.setString(3,product.getName_pr());
        pstm.setInt(4,product.getQuantity());
        pstm.setFloat(5,product.getCost());
        pstm.executeUpdate();
    }

    // Удаление продукта
    public static void deleteProduct(Connection conn, String id_product) throws SQLException {
        try {
            String sql = "DELETE FROM products WHERE id_product = " + "'" + id_product + "'";
            PreparedStatement pstm = conn.prepareStatement(sql);
            pstm.executeUpdate();
        } catch (SQLException e) {
            System.out.println(e);
        }
    }

    public static Clients queryClient(Connection connection,String login){
        String name = "",surname = "",email = "",telephone = "";
        try {
            String sqlQueryCleint = "SELECT name,surname,email,telephone FROM clients WHERE login = " + "'" + login + "'";
            PreparedStatement pstm = connection.prepareStatement(sqlQueryCleint);
            ResultSet resultSet = pstm.executeQuery();

            while (resultSet.next()){
                name = resultSet.getString("name");
                surname = resultSet.getString("surname");
                email = resultSet.getString("email");
                telephone = resultSet.getString("telephone");
            }

            return new Clients(name,surname,email,telephone);
        } catch (SQLException e) {
            System.out.println(e);
            return null;
        }
    }
}