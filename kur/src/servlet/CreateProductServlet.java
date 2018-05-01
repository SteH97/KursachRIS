package servlet;

import java.io.IOException;
import java.sql.Connection;
import java.sql.SQLException;

import javax.servlet.RequestDispatcher;
import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import beans.Product;
import utils.DBUtils;
import utils.MyUtils;

@WebServlet(urlPatterns = { "/createProduct" })
public class CreateProductServlet extends HttpServlet {
    private static final long serialVersionUID = 1L;

    public CreateProductServlet() {
        super();
    }

    // Отобразить страницу создания продукта.
    @Override
    protected void doGet(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {

        RequestDispatcher dispatcher = request.getServletContext()
                .getRequestDispatcher("/WEB-INF/views/createProductView.jsp");
        dispatcher.forward(request, response);
    }

    // Когда пользователь вводит информацию продукта, и нажимает Submit.
    // Этот метод будет вызван.
    @Override
    protected void doPost(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        Connection conn = MyUtils.getStoredConnection(request);

        float costFl = 0;int quantityInt = 0;

        String type = request.getParameter("type");
        String brand = request.getParameter("brand");
        String name_pr = request.getParameter("name_pr");
        String quantity = request.getParameter("quantity");
        String cost = request.getParameter("cost");

        try {
            costFl = Float.parseFloat(cost);
            quantityInt = Integer.parseInt(quantity);
        } catch (Exception e) {
            System.out.println("Ошибка в парсе чисел");
        }
        Product product = new Product(type,brand,name_pr,quantityInt,costFl);

        String errorString = null;

        // Кодом продукта является строка [a-zA-Z_0-9]
        // Имеет минимум 1 символ.
        String regex = "\\w+";

        if (type.equals("") || brand.equals("") || name_pr.equals("") || quantity.equals("") || cost.equals("")) {
            errorString = "Product invalid!";
        }

        if (errorString == null) {
            try {
                DBUtils.insertProduct(conn, product);
            } catch (SQLException e) {
                e.printStackTrace();
                errorString = e.getMessage();
            }
        }

        // Сохранить информацию в request attribute перед тем как forward к views.
        request.setAttribute("errorString", errorString);
        request.setAttribute("product", product);

        // Если имеется ошибка forward (перенаправления) к странице 'edit'.
        if (errorString != null) {
            RequestDispatcher dispatcher = request.getServletContext()
                    .getRequestDispatcher("/WEB-INF/views/createProductView.jsp");
            dispatcher.forward(request, response);
        }
        // Если все хорошо.
        // Redirect (перенаправить) к странице со списком продуктов.
        else {
            response.sendRedirect(request.getContextPath() + "/productList");
        }
    }

}
