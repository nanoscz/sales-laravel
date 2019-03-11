DELIMITER //
CREATE TRIGGER tr_update_stock_ingreso AFTER INSERT ON income_detail
	FOR EACH ROW BEGIN
	UPDATE article SET stock = stock + NEW.quantity
    WHERE article.id = NEW.id_article;
END
//
DELIMITER ;