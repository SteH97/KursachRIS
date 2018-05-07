<%--
  Created by IntelliJ IDEA.
  User: Кирилл
  Date: 25.04.2018
  Time: 19:05
  To change this template use File | Settings | File Templates.
--%>
<%@ page language="java" contentType="text/html; charset=UTF-8" pageEncoding="UTF-8"%>
<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c" %>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Редактирование продукта</title>
</head>
<body>

<jsp:include page="_header.jsp"></jsp:include>
<jsp:include page="_menu.jsp"></jsp:include>

<h3>Редактирование продукта</h3>

<p style="color: red;">${errorString}</p>
<p style="color: red;">${updateSuccess}</p>

<form method="POST" action="${pageContext.request.contextPath}/editProduct">
    <table border="0">
            <tr>
                <td>Номер</td>
                <td><input type="text" name="id"/></td>
            </tr>
            <tr>
                <td>Количество</td>
                <td><input type="text" name="quantity"/></td>
            </tr>
            <tr>
                <td>Цена</td>
                <td><input type="text" name="cost"/></td>
            </tr>
            <tr>
                <td colspan = "2">
                    <input type="submit" value="Submit"/>
                    <a href="${pageContext.request.contextPath}/adminServlet">Cancel</a>
                </td>
            </tr>
    </table>
</form>


<jsp:include page="_footer.jsp"></jsp:include>

</body>
</html>
