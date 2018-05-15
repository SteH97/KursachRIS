package servlet;

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
import java.util.ArrayList;

@WebServlet(urlPatterns = { "/ratingProduct" })
public class RatingProductServlet extends HttpServlet{

    RatingProductServlet() {
        super();
    }

    @Override
    protected void doGet(HttpServletRequest req, HttpServletResponse resp) throws ServletException, IOException {
        HttpSession session = req.getSession();

        // Проверить, вошел ли пользователь в систему (login) или нет.
        UserAccount loginedUser = MyUtils.getLoginedUser(session);
        Connection conn = MyUtils.getStoredConnection(req);
        // Если еще не вошел в систему (login).
        if (loginedUser == null) {
            // Redirect (Перенаправить) к странице login.
            resp.sendRedirect(req.getContextPath() + "/login");
            return;
        } else if(loginedUser != null) {
            // Сохранить информацию в request attribute перед тем как forward (перенаправить).
            req.setAttribute("nameHeader","Рейтинг");
            req.setAttribute("user", loginedUser);
            req.setAttribute("typeOperationUser","rating");
            ArrayList ordersProducts = DBUtils.queryOrderClient(conn,loginedUser.getUserName(),"confirmed");
            req.setAttribute("orderProducts",ordersProducts);
            RequestDispatcher dispatcher //
                    = this.getServletContext().getRequestDispatcher("/WEB-INF/views/userInfoView.jsp");
            dispatcher.forward(req, resp);
        }
    }

    @Override
    protected void doPost(HttpServletRequest req, HttpServletResponse resp) throws ServletException, IOException {
        doGet(req, resp);
    }
}
