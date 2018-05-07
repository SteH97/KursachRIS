<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%--
  Created by IntelliJ IDEA.
  User: Alex SteH
  Date: 28.04.2018
  Time: 11:52
  To change this template use File | Settings | File Templates.
--%>
<%@ page contentType="text/html;charset=UTF-8" language="java" %>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Вошел: ${admin}</title>
</head>
<body>

<jsp:include page="_header.jsp"></jsp:include>
<jsp:include page="_menu.jsp"></jsp:include>

<h3>Product List</h3>

<p style="color: red;">${errorString}</p>

<table border="1" cellpadding="5" cellspacing="1" >
    <tr>
        <th>Номер</th>
        <th>Тип</th>
        <th>Бренд</th>
        <th>Название</th>
        <th>Тип</th>
        <th>Рейтинг</th>
        <th>Цена</th>
    </tr>
    <c:forEach items="${productListAdmin}" var="products" >
        <tr>
            <td>${products.getId_product()}</td>
            <td>${products.getType()}</td>
            <td>${products.getBrand()}</td>
            <td>${products.getName_pr()}</td>
            <td>${products.getQuantity()}</td>
            <td>${products.getRating()}</td>
            <td>${products.getCost()}</td>
        </tr>
    </c:forEach>
</table>

<a href="createProduct" >Добавить</a>
<a href="deleteProduct" >Удалить</a>
<a href="editProduct" >Редактировать</a>

<jsp:include page="_footer.jsp"></jsp:include>
</body>
</html>
