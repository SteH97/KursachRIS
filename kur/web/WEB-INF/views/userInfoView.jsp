<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>
<%--
  Created by IntelliJ IDEA.
  User: Кирилл
  Date: 25.04.2018
  Time: 18:59
  To change this template use File | Settings | File Templates.
--%>
<%@ page language="java" contentType="text/html; charset=UTF-8"
         pageEncoding="UTF-8"%>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Личный кабинет</title>
</head>
<body>

<jsp:include page="_header.jsp"></jsp:include>
<jsp:include page="_menu.jsp"></jsp:include>
<div>
    <label>Здравствуйте, ${user.getUserName()}</label>
</div>

<p style="color: red;">${errorString}</p>

<div>
    <div>
        <a href="${pageContext.request.contextPath}/userInfo">Личный кабинет</a>
        <a href="${pageContext.request.contextPath}/myOrders">Мои заказы</a>
        <a href="${pageContext.request.contextPath}/editProfile">Редактировать профиль</a>
        <a href="${pageContext.request.contextPath}/ratingProduct">Оценить продукт</a>
    </div>

    <div>
        <header>
            <h1>${nameHeader}</h1>
        </header>
        <div>
            <c:choose>

                <%-- Работает --%>
                <c:when test="${typeOperationUser == 'personalData'}">
                        <label>Имя:</label>
                        <p>${client.getName()}</p>
                        <label>Фамилия:</label>
                        <p>${client.getSurname()}</p>
                        <label>Почта:</label>
                        <p>${client.getEmail()}</p>
                        <label>Телефон:</label>
                        <p>${client.getTelephone()}</p>
                </c:when>

                <%-- Работает --%>
                <c:when test="${typeOperationUser == 'orders'}">
                        <c:forEach items="${orderProducts}" var="product">
                            <div>
                                <label>Номер заказа:</label>
                                <p>${product.getId_order()}</p>
                                <div>
                                    <label>Тип:</label>
                                    <p>${product.getType()}</p>
                                    <label>Бренд:</label>
                                    <p>${product.getBrand()}</p>
                                    <label>Название:</label>
                                    <p>${product.getName_pr()}</p>
                                    <label>Статус:</label>
                                    <p>${product.getStatus()}</p>
                                    <label>Рейтинг:</label>
                                    <p>${product.getRating()}</p>
                                </div>
                            </div>
                        </c:forEach>
                </c:when>

                <%-- Работает --%>
                <c:when test="${typeOperationUser == 'edit'}">
                    <form method="post" action="/operationEdit">
                        <label>Имя</label>
                        <input type="text" name="userNameEdit" value="${client.getName()}"/>
                        <label>Фамилия</label>
                        <input type="text" name="userSurnameEdit" value="${client.getSurname()}"/>
                        <label>Почта</label>
                        <input type="text" name="userEmailEdit" value="${client.getEmail()}"/>
                        <label>Телефон</label>
                        <input type="text" name="userTelephoneEdit" value="${client.getTelephone()}"/>

                        <input type="submit" value="Редактировать"/>
                    </form>
                </c:when>

                <c:when test="${typeOperationUser == 'rating'}">
                    <form method="post" action="/operationRating">
                        <% int i =0;%>
                        <c:forEach items="orderProducts" var="product">
                            <div>
                                <label>Номер заказа:</label>
                                <p>${product.getId_order()}</p>
                                <label>Тип:</label>
                                <p>${product.getType()}</p>
                                <label>Название:</label>
                                <p>${product.getName()}</p>
                                <select >
                                    <option name='ratingOne" + ${i}"'>1</option>
                                    <option name='ratingTwo" + ${i}"'>2</option>
                                    <option name='ratingThree" + ${i}"'>3</option>
                                    <option name='ratingFour" + ${i}"'>4</option>
                                    <option name='ratingFive" + ${i}"'>5</option>
                                </select>
                                <input type="submit" value="Оценить"/>
                            </div>
                            <% i++;%>
                        </c:forEach>
                    </form>
                </c:when>
            </c:choose>
        </div>
    </div>
</div>

<jsp:include page="_footer.jsp"></jsp:include>

</body>
</html>
