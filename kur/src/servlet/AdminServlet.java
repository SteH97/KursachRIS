package servlet;

import beans.Admin;
import beans.Product;
import beans.UserAccount;
import utils.DBUtils;
import utils.MyUtils;

import javax.servlet.RequestDispatcher;
import javax.servlet.ServletException;
import javax.servlet.annotation.WebServlet;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;
import javax.servlet.http.HttpSession;
import java.io.IOException;
import java.sql.Connection;
import java.sql.SQLException;
import java.util.List;

@WebServlet(urlPatterns = { "/adminServlet" })
public class AdminServlet extends HttpServlet{

    public AdminServlet() {
        super();
    }

    @Override
    protected void doGet(HttpServletRequest req, HttpServletResponse resp)
            throws ServletException, IOException {
        HttpSession session = req.getSession();
        Connection conn = MyUtils.getStoredConnection(req);
        // Проверить, вошел ли пользователь в систему (login) или нет.
        Admin loginedAdmin = MyUtils.getLoginedAdmin(session);
        String adminTitle = loginedAdmin.getLogin();
        String errorString = null;
        List<Product> list = null;

        // Если еще не вошел в систему (login).
        if (loginedAdmin == null) {
            // Redirect (Перенаправить) к странице login.
            resp.sendRedirect(req.getContextPath() + "/login");
            return;
        }

        try {
            list = DBUtils.queryProduct(conn);
        } catch (SQLException e) {
            e.printStackTrace();
            errorString = e.getMessage();
        }
        // Сохранить информацию в request attribute перед тем как forward (перенаправить).
        req.setAttribute("admin", adminTitle);
        req.setAttribute("productListAdmin", list);
        req.setAttribute("errorString", errorString);
        // Если пользователь уже вошел в систему (login), то forward (перенаправить) к странице
        // /WEB-INF/views/userInfoView.jsp
        RequestDispatcher dispatcher //
                = this.getServletContext().getRequestDispatcher("/WEB-INF/views/adminView.jsp");
        dispatcher.forward(req, resp);
    }

    @Override
    protected void doPost(HttpServletRequest req, HttpServletResponse resp) throws ServletException, IOException {
        doGet(req, resp);
    }
}
