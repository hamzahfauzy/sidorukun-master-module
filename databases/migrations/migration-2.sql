CREATE TABLE mst_channels (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_by INT DEFAULT NULL,
    updated_at DATETIME DEFAULT NULL,
    updated_by INT DEFAULT NULL,

    CONSTRAINT fk_mst_channels_created_by FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL,
    CONSTRAINT fk_mst_channels_updated_by FOREIGN KEY (updated_by) REFERENCES users(id) ON DELETE SET NULL
);

CREATE TABLE trn_receives (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(100) NOT NULL,
    receive_date DATETIME DEFAULT NULL,
    supplier_id INT DEFAULT NULL,
    supplier_name VARCHAR(100) NOT NULL,
    total_items INT NOT NULL,
    total_qty INT NOT NULL,
    cancel_reason TEXT DEFAULT NULL,
    status VARCHAR(100) DEFAULT NULL,
    description TEXT DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_by INT DEFAULT NULL,
    updated_at DATETIME DEFAULT NULL,
    updated_by INT DEFAULT NULL,

    CONSTRAINT fk_trn_receives_supplier_id FOREIGN KEY (supplier_id) REFERENCES mst_suppliers(id) ON DELETE SET NULL,
    CONSTRAINT fk_trn_receives_created_by FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL,
    CONSTRAINT fk_trn_receives_updated_by FOREIGN KEY (updated_by) REFERENCES users(id) ON DELETE SET NULL
);

CREATE TABLE trn_receive_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    receive_id INT NOT NULL,
    order_number INT DEFAULT NULL,
    item_id INT DEFAULT NULL,
    item_object JSON NOT NULL,
    qty INT NOT NULL,
    unit VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_by INT DEFAULT NULL,
    updated_at DATETIME DEFAULT NULL,
    updated_by INT DEFAULT NULL,

    CONSTRAINT fk_trn_receive_items_receive_id FOREIGN KEY (receive_id) REFERENCES trn_receives(id) ON DELETE CASCADE,
    CONSTRAINT fk_trn_receive_items_item_id FOREIGN KEY (item_id) REFERENCES mst_items(id) ON DELETE SET NULL,
    CONSTRAINT fk_trn_receive_items_created_by FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL,
    CONSTRAINT fk_trn_receive_items_updated_by FOREIGN KEY (updated_by) REFERENCES users(id) ON DELETE SET NULL
);

CREATE TABLE trn_outgoings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(100) NOT NULL,
    outgoing_date DATETIME DEFAULT NULL,
    channel_id INT DEFAULT NULL,
    channel_name VARCHAR(100) NOT NULL,
    customer_id INT DEFAULT NULL,
    customer_name VARCHAR(100) NOT NULL,
    outgoing_type VARCHAR(100) NOT NULL,
    order_code VARCHAR(100) DEFAULT NULL,
    receipt_code VARCHAR(100) DEFAULT NULL,
    total_items INT NOT NULL,
    total_qty INT NOT NULL,
    cancel_reason TEXT DEFAULT NULL,
    status VARCHAR(100) DEFAULT NULL,
    description TEXT DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_by INT DEFAULT NULL,
    updated_at DATETIME DEFAULT NULL,
    updated_by INT DEFAULT NULL,

    CONSTRAINT fk_trn_outgoings_channel_id FOREIGN KEY (channel_id) REFERENCES mst_channels(id) ON DELETE SET NULL,
    CONSTRAINT fk_trn_outgoings_customer_id FOREIGN KEY (customer_id) REFERENCES mst_customers(id) ON DELETE SET NULL,
    CONSTRAINT fk_trn_outgoings_created_by FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL,
    CONSTRAINT fk_trn_outgoings_updated_by FOREIGN KEY (updated_by) REFERENCES users(id) ON DELETE SET NULL
);

CREATE TABLE trn_outgoing_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    outgoing_id INT NOT NULL,
    order_number INT DEFAULT NULL,
    item_id INT DEFAULT NULL,
    item_object JSON NOT NULL,
    qty INT NOT NULL,
    unit VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_by INT DEFAULT NULL,
    updated_at DATETIME DEFAULT NULL,
    updated_by INT DEFAULT NULL,

    CONSTRAINT fk_trn_outgoing_items_receive_id FOREIGN KEY (outgoing_id) REFERENCES trn_outgoings(id) ON DELETE CASCADE,
    CONSTRAINT fk_trn_outgoing_items_item_id FOREIGN KEY (item_id) REFERENCES mst_items(id) ON DELETE SET NULL,
    CONSTRAINT fk_trn_outgoing_items_created_by FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL,
    CONSTRAINT fk_trn_outgoing_items_updated_by FOREIGN KEY (updated_by) REFERENCES users(id) ON DELETE SET NULL
);

CREATE TABLE trn_adjusts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    code VARCHAR(100) NOT NULL,
    adjust_date DATETIME DEFAULT NULL,
    item_id INT DEFAULT NULL,
    item_object JSON NOT NULL,
    qty INT NOT NULL,
    unit VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    created_by INT DEFAULT NULL,
    updated_at DATETIME DEFAULT NULL,
    updated_by INT DEFAULT NULL,

    CONSTRAINT fk_trn_adjusts_item_id FOREIGN KEY (item_id) REFERENCES mst_items(id) ON DELETE SET NULL,
    CONSTRAINT fk_trn_adjusts_created_by FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL,
    CONSTRAINT fk_trn_adjusts_updated_by FOREIGN KEY (updated_by) REFERENCES users(id) ON DELETE SET NULL
);