CREATE DATABASE penjualan;

use penjualan;

CREATE TABLE login (
    user VARCHAR(50) PRIMARY KEY NOT NULL COMMENT 'User Login',
    password VARCHAR(255) NOT NULL COMMENT 'Password User'
)Engine=InnoDB;

CREATE TABLE products (
    product_code VARCHAR(18) PRIMARY KEY NOT NULL COMMENT 'Kode Produk',
    product_name VARCHAR(30) NOT NULL COMMENT 'Nama Produk',
    price INT(6) NOT NULL COMMENT 'Harga Jual Produk dalam satuan currency',
    currency VARCHAR(5) NOT NULL COMMENT 'Satuan Harga Jual',
    discount INT(6) NOT NULL COMMENT 'Diskon dalam %',
    dimension VARCHAR(50) NOT NULL COMMENT 'Dimensi Produk',
    unit VARCHAR(5) NOT NULL COMMENT 'Satuan Jual Produk'
)Engine=InnoDB;

CREATE TABLE transaction_header (
    document_code VARCHAR(3) PRIMARY KEY NOT NULL COMMENT 'Kode Dokumen',
    document_number VARCHAR(10) NOT NULL COMMENT 'Nomer Dokumen',
    user VARCHAR(50) COMMENT 'User Login',
    total INT(10) COMMENT 'Total Harga Jual',
    date DATE COMMENT 'Tanggal Transaksi',
    Foreign Key fk_user_transaction_header (user) REFERENCES login(user)
)Engine=InnoDB;

CREATE TABLE transaction_detail (
    document_code VARCHAR(3) NOT NULL COMMENT 'Kode Dokumen',
    document_number VARCHAR(10) NOT NULL COMMENT 'Nomer Dokumen',
    product_code VARCHAR(18) NOT NULL COMMENT 'Kode Produk',
    price INT(6) NOT NULL COMMENT 'Harga Jual produk dalam satuan currency',
    quantity INT(6) NOT NULL COMMENT 'Jumlah qty barang yang dibeli',
    unit VARCHAR(5) NOT NULL COMMENT 'Satuan Jual PRoduk',
    sub_total INT(10) NOT NULL COMMENT 'Total harga per item',
    currency VARCHAR(5) NOT NULL COMMENT 'Satuan Harga',
    Foreign Key fk_products_transaction_detail(product_code) REFERENCES products(product_code)
)Engine=InnoDB;