DELIMITER //
CREATE TRIGGER tr_update_stock_canceled_sales AFTER UPDATE ON sales
	FOR EACH ROW BEGIN
	UPDATE article
    JOIN sales_detail
    ON sales_detail.id_article = article.id
    AND sales_detail.id_sale = NEW.id
    SET article.stock = article.stock + sales_detail.quantity;
END
//
DELIMITER ;