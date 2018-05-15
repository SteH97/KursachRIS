package utils;

import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ArrayList;
import java.util.List;

import beans.*;
import jdk.nashorn.internal.runtime.OptimisticReturnFilters;

public class DBUtils {

    // Авторизация клиента
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

    // Авторизация админа
    public static Admin findAdmin(Connection conn, //
                                       String adminLogin, String adminPassword) throws SQLException {

        String sql = "SELECT login,password FROM admin WHERE login = " + "'" + adminLogin + "'" + " AND password = " + "'" + adminPassword + "'";

        PreparedStatement preparedStatement = conn.prepareStatement(sql);
        ResultSet rs = preparedStatement.executeQuery();

        if (rs.next()) {
            String login = rs.getString("login");
            String password = rs.getString("password");
            Admin admin = new Admin(login,password);

            return admin;
        }

        return null;
    }

    public static UserAccount findClient(Connection conn, String adminLogin) throws SQLException {

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

    // Регистрация клиента
    public static void insertClient(Connection connection,String login,String password,
                                    String clientName,String clientSurname,String clientEmail,String clientTelephone) throws SQLException{

        String sqlInsertAuthorization = "INSERT INTO authorization(login, password) VALUES (" + "'" + login + "'" + ',' + "'" + password + "'" + ")";
        PreparedStatement preparedStatementAuthorization = connection.prepareStatement(sqlInsertAuthorization);
        preparedStatementAuthorization.executeUpdate();

        String sqlInsertClient = "INSERT INTO clients(login,name,surname,email,telephone)" +
                " VALUES (" + "'" + login + "'" + "," + "'" + clientName + "'" + "," + "'" + clientSurname + "'" + "," + "'" + clientEmail + "'" + "," + "'" + clientTelephone + "'" + ")";
        PreparedStatement preparedStatementClient = connection.prepareStatement(sqlInsertClient);
        preparedStatementClient.executeUpdate();
    }

    // Получение личной ифнормации клиента
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

    // Обновление личной информации клиента
    public static void updateClient(Connection connection,String login,String name,String surname,String email,String telephone) throws SQLException{
        try {
            String sqlUpdate =
                    "UPDATE clients " +
                            "SET name = " + "'" + name + "'" + ", surname = " + "'" + surname + "'" + ", email = " + "'" + email + "'" + ", telephone = " + "'" + telephone + "'" +
                            " WHERE login = " + "'" + login + "'";
            PreparedStatement preparedStatement = connection.prepareStatement(sqlUpdate);
            preparedStatement.executeUpdate();
        } catch (SQLException e) {
            System.out.println(e);
        }
    }

    // Список продуктов
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

    // Список заказов клиента // Все или Подтвержденые
    public static ArrayList<Product> queryOrderClient(Connection connection,String login,String operationOrders) {

        ArrayList<Integer> idProducts = new ArrayList<>();
        ArrayList<Integer> idOrders = new ArrayList<>();
        ArrayList<Integer> quantitys = new ArrayList<>();
        ArrayList<String> statusOrders = new ArrayList<>();

        ArrayList all = new ArrayList();
        ArrayList<Product> products = new ArrayList<>();

        switch (operationOrders) {
            case "all": {
                try {

                    String sqlQueryOrders = "SELECT id_order,id_product,status,quantity FROM orders WHERE login = " + "'" + login + "'";
                    PreparedStatement preparedStatement = connection.prepareStatement(sqlQueryOrders);
                    ResultSet resultSet = preparedStatement.executeQuery();

                    while (resultSet.next()) {
                        int id_order = resultSet.getInt("id_order");
                        int id_product = resultSet.getInt("id_product");
                        String status = resultSet.getString("status");
                        int quantity = resultSet.getInt("quantity");

                        idOrders.add(id_order);
                        idProducts.add(id_product);
                        quantitys.add(quantity);
                        statusOrders.add(status);
                    }

                    for (int i = 0; i < idProducts.size(); i++) {
                        String sqlQueryProduct = "select * from products WHERE id_product = " + "'" + idProducts.get(i) + "'";
                        PreparedStatement preparedStatementProduct = connection.prepareStatement(sqlQueryProduct);
                        ResultSet resultSetProduct = preparedStatementProduct.executeQuery();

                        while (resultSetProduct.next()) {
                            String type = resultSetProduct.getString("type");
                            String brand = resultSetProduct.getString("brand");
                            String name_pr = resultSetProduct.getString("name_pr");
                            int rating = resultSetProduct.getInt("rating");
                            float cost = resultSetProduct.getFloat("cost");

                            products.add(new Product(idOrders.get(i), type, brand, name_pr, statusOrders.get(i), quantitys.get(i), rating, cost));
                        }
                    }

                } catch (SQLException e) {
                    System.out.println(e);
                }
                break;
            }

            case "confirmed": {
                try{

                    String sqlQueryConfirmedOrders = "SELECT id_order,id_product,quantity FROM orders WHERE login = " + "'" + login + "'"
                            + " AND status = " + "'" + "Подтвержден" + "'";
                    PreparedStatement preparedStatementConfirmedOrders = connection.prepareStatement(sqlQueryConfirmedOrders);
                    ResultSet resultSetConfirmedOrders = preparedStatementConfirmedOrders.executeQuery();

                    while (resultSetConfirmedOrders.next()){
                        int id_product = resultSetConfirmedOrders.getInt("id_product");
                        int quantity = resultSetConfirmedOrders.getInt("quantity");
                        int id_order = resultSetConfirmedOrders.getInt("id_order");

                        idOrders.add(id_order);
                        idProducts.add(id_product);
                        quantitys.add(quantity);
                    }

                    for (int i = 0;i < idProducts.size();i++){

                        String sqlQueryProduct = "select type,name_pr from products WHERE id_product = " + "'" + idProducts.get(i) + "'";
                        PreparedStatement preparedStatementProduct = connection.prepareStatement(sqlQueryProduct);
                        ResultSet resultSetProduct = preparedStatementProduct.executeQuery();

                        while (resultSetProduct.next()) {
                            String type = resultSetProduct.getString("type");
                            String brand = resultSetProduct.getString("brand");
                            String name_pr = resultSetProduct.getString("name_pr");

//                            products.add(new Product(idOrders.get(i), type, brand, name_pr);
                        }
                    }

                } catch (SQLException e) {
                    System.out.println(e);
                }
                break;
            }
        }

        return products;
    }

    // Добавление нового заказа
    public static void insertOrder(Connection connection,String id_product,String login,String quantity) {
        try {
            String insertOrder = "INSERT INTO orders()";
            PreparedStatement preparedStatement = connection.prepareStatement(insertOrder);
            preparedStatement.executeUpdate();
        } catch (SQLException e) {
            System.out.println(e);
        }
    }
}