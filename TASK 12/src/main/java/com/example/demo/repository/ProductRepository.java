package com.example.demo.repository;

import java.util.List;
import java.util.Optional;

import org.springframework.data.jpa.repository.JpaRepository;
import org.springframework.data.jpa.repository.Query;

import com.example.demo.entity.Product;

public interface ProductRepository extends JpaRepository<Product, Integer> {

    @Query("SELECT p FROM Product p WHERE p.name=?1")
    Optional<Product> findByName(String name);

    @Query(value="SELECT * FROM product", nativeQuery=true)
    List<Product> findAllProducts();

    Optional<Product> findByCost(double cost);
}