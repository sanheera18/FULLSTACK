package Maven.edu.Sun;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Component;

@Component
public class Set_DI {
	@Autowired
	private Engine engine;
	public void setEngine(Engine engine) {
		this.engine=engine;
	}
	public void drive() {
		engine.start();
		System.out.println("Car is moving from Setter DI....");
	}
}
