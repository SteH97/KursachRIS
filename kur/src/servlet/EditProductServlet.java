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
import javax.servlet.http.HttpSession;

import beans.Admin;
import beans.Product;
import utils.DBUtils;
import utils.MyUtils;

@WebServlet(urlPatterns = { "/editProduct" })
public class EditProductServlet extends HttpServlet {
    private static final long serialVersionUID = 1L;

    public EditProductServlet() {
        super();
    }

    // Отобразить страницу редактирования продукта.
    @Override
    protected void doGet(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        HttpSession httpSession = request.getSession();

        Admin admin = MyUtils.getLoginedAdmin(httpSession);

        if(admin == null) {
            response.sendRedirect(request.getContextPath() + "/login");
        } else if(admin != null) {
            RequestDispatcher dispatcher = request.getServletContext()
                    .getRequestDispatcher("/WEB-INF/views/editProductView.jsp");
            dispatcher.forward(request, response);
        }
    }

    // После того, как пользователь отредактировал информацию продукта и нажал на Submit.
    // Данный метод будет выполнен.
    @Override
    protected void doPost(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        Connection conn = MyUtils.getStoredConnection(request);

        String errorString = null;

        String id = request.getParameter("id");
        String quantity = request.getParameter("quantity");
        String cost = request.getParameter("cost");
        System.out.println(id);
        if(toIntId(id)) {
            try {
                DBUtils.updateProduct(conn, id, quantity, cost);
            } catch (SQLException e) {
                e.printStackTrace();
                errorString = e.getMessage();
            }
        } else {
            errorString = "Некорректный ввод номера";
        }

        // Если имеется ошибка, forward к странице edit.
        if (errorString != null) {
            request.setAttribute("errorString", errorString);
            RequestDispatcher dispatcher = request.getServletContext()
                    .getRequestDispatcher("/WEB-INF/views/editProductView.jsp");
            dispatcher.forward(request, response);
        }
        // Если все хорошо.
        // Redirect к странице со списком продуктов.
        else {
            request.setAttribute("updateSuccess", "Успешное редактирование");
            RequestDispatcher dispatcher //
                    = this.getServletContext().getRequestDispatcher("/WEB-INF/views/editProductView.jsp");

            dispatcher.forward(request, response);
        }
    }

    // Проверка на коррекстность ввода номера
    private boolean toIntId(String id) {
        try {
            Integer.parseInt(id);
            return true;
        } catch (Exception e) {
            return false;
        }
    }
}
