package Maven.edu.Sun;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Component;
@Component
public class Con_DI {
	private Engine engine;
	@Autowired
	public Con_DI(Engine engine) {
		this.engine=engine;
	}
	public void drive() {
		engine.start();
		System.out.println("Car is moving from Constructore DI");
	}
}
