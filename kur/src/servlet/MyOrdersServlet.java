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

@WebServlet(urlPatterns = { "/myOrders" })
public class MyOrdersServlet extends HttpServlet{
    private static final long serialVersionUID = 1L;

    public MyOrdersServlet() {
        super();
    }

    @Override
    protected void doGet(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        HttpSession session = request.getSession();

        // Проверить, вошел ли пользователь в систему (login) или нет.
        UserAccount loginedUser = MyUtils.getLoginedUser(session);
        Connection conn = MyUtils.getStoredConnection(request);
        // Если еще не вошел в систему (login).
        if (loginedUser == null) {
            // Redirect (Перенаправить) к странице login.
            response.sendRedirect(request.getContextPath() + "/login");
            return;
        } else if(loginedUser != null) {
            // Сохранить информацию в request attribute перед тем как forward (перенаправить).
            String allOrders = "all";
            request.setAttribute("nameHeader","Заказы");
            request.setAttribute("user", loginedUser);
            request.setAttribute("typeOperationUser","orders");
            ArrayList<Product> ordersProducts = DBUtils.queryOrderClient(conn,loginedUser.getUserName(),allOrders);

            request.setAttribute("orderProducts",ordersProducts);
            RequestDispatcher dispatcher //
                    = this.getServletContext().getRequestDispatcher("/WEB-INF/views/userInfoView.jsp");
            dispatcher.forward(request, response);
        }
    }

    @Override
    protected void doPost(HttpServletRequest request, HttpServletResponse response)
            throws ServletException, IOException {
        doGet(request, response);
    }

}
