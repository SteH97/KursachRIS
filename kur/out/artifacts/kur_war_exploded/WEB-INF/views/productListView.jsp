<%--
  Created by IntelliJ IDEA.
  User: Кирилл
  Date: 25.04.2018
  Time: 19:00
  To change this template use File | Settings | File Templates.
--%>
<%@ page language="java" contentType="text/html; charset=UTF-8"
         pageEncoding="UTF-8"%>
<%@ taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c" %>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Список товаров</title>
</head>
<body>

<jsp:include page="_header.jsp"></jsp:include>
<jsp:include page="_menu.jsp"></jsp:include>

<h3>Product List</h3>

<table border="1" cellpadding="5" cellspacing="1" >
    <tr>
        <th>Тип</th>
        <th>Бренд</th>
        <th>Название</th>
        <th>Рейтинг</th>
        <th>Цена</th>
    </tr>
    <c:forEach items="${productList}" var="products" >
        <tr>
            <td>${products.getType()}</td>
            <td>${products.getBrand()}</td>
            <td>${products.getName_pr()}</td>
            <td>${products.getRating()}</td>
            <td>${products.getCost()}</td>
        </tr>
    </c:forEach>
</table>

<jsp:include page="_footer.jsp"></jsp:include>

</body>
</html>