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

import utils.DBUtils;
import utils.MyUtils;

@WebServlet(urlPatterns = { "/deleteProduct" })
public class DeleteProductServlet extends HttpServlet {
    private static final long serialVersionUID = 1L;

    public DeleteProductServlet() {
        super();
    }

    @Override
    protected void doGet(HttpServletRequest req, HttpServletResponse resp) throws ServletException, IOException {
        RequestDispatcher dispatcher //
                = this.getServletContext().getRequestDispatcher("/WEB-INF/views/deleteProductErrorView.jsp");

        dispatcher.forward(req, resp);
    }

    @Override
    protected void doPost(HttpServletRequest req, HttpServletResponse resp) throws ServletException, IOException {
        Connection conn = MyUtils.getStoredConnection(req);

        String id_product = req.getParameter("id_product");
        String errorString = null;

        if(toIntId(id_product)) {
            try {
                DBUtils.deleteProduct(conn, id_product);
            } catch (SQLException e) {
                e.printStackTrace();
                errorString = e.getMessage();
            }
        } else {
            errorString = "Некорректный ввод номера";
        }


        // Если происходит ошибка, forward (перенаправить) к странице оповещающей ошибку.
        if (errorString != null) {
            // Сохранить информацию в request attribute перед тем как forward к views.
            req.setAttribute("errorString", errorString);
            //
            RequestDispatcher dispatcher = req.getServletContext()
                    .getRequestDispatcher("/WEB-INF/views/deleteProductErrorView.jsp");
            dispatcher.forward(req, resp);
        }
        // Если все хорошо.
        // Redirect (перенаправить) к странице со списком продуктов.
        else {
            req.setAttribute("deleteSuccess", "Успешное удаление");
            RequestDispatcher dispatcher //
                    = this.getServletContext().getRequestDispatcher("/WEB-INF/views/deleteProductErrorView.jsp");

            dispatcher.forward(req, resp);
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
