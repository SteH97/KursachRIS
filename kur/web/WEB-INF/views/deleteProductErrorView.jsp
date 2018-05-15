<%--
  Created by IntelliJ IDEA.
  User: Кирилл
  Date: 25.04.2018
  Time: 19:06
  To change this template use File | Settings | File Templates.
--%>
<%@ page language="java" contentType="text/html; charset=UTF-8"
         pageEncoding="UTF-8"%>
<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c"%>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Удаление продукта</title>
</head>

<body>

<jsp:include page="_header.jsp"></jsp:include>
<jsp:include page="_menu.jsp"></jsp:include>

<h3>Delete Product</h3>

<p style="color: red;">${errorString}</p>
<p style="color: red;">${deleteSuccess}</p>
<form method="post" action="${pageContext.request.contextPath}/deleteProduct" var="product">
    <table border="0">
        <tr>
            <td>Номер продукта</td>
            <td><input type="text" name="id_product"/> </td>
        </tr>
        <tr>
            <td colspan ="2">
                <input type="submit" value= "Submit" />
                <a href="${pageContext.request.contextPath}/adminServlet">Cancel</a>
            </td>
        </tr>
    </table>
</form>

<jsp:include page="_footer.jsp"></jsp:include>

</body>
</html>
