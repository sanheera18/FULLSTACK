package com.example.demo.service;

import java.util.List;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import com.example.demo.entity.Product;
import com.example.demo.repository.ProductRepository;

@Service
public class ProductService {

    @Autowired
    ProductRepository repo;

    public List<Product> getProducts(){
        return repo.findAll();
    }

    public Product getProductByCost(Double cost){
        return repo.findByCost(cost).orElse(null);
    }

    public Product getProduct(int id){
        return repo.findById(id).orElse(null);
    }

    public Product getProductByName(String name){
        return repo.findByName(name).orElse(null);
    }

    public Product addData(Product product){
        return repo.save(product);
    }
}