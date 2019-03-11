DELIMITER //
CREATE TRIGGER rt_update_stock_canceled_income AFTER UPDATE on income
	FOR EACH ROW BEGIN
    UPDATE article 
    JOIN income_detail
    ON income_detail.id_article = article.id
    AND income_detail.id_income = NEW.id
    SET article.stock = article.stock - income_detail.quantity;
END;
//
DELIMITER ;