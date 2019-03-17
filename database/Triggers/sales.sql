DELIMITER //
CREATE TRIGGER rt_update_stock_sales AFTER INSERT on sales_detail
    FOR EACH ROW BEGIN UPDATE article 
    SET article.stock = article.stock - NEW.quantity 
    WHERE article.id = NEW.id_article; 
END;
//
DELIMITER;