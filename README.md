# Lab: Diagnóstico y Reparación SOLID - BovWeight CR

**UCR - Sede Guanacaste** | Ingeniería del Software | Prof. Alonso Chavarría

**Estudiantes:** Ashley Dariana Narvaez Umaña C35538
                 Nathalie Tamara Caballero Jarquín C31386


# Reparaciones y Análisis de los Casos

### Ficha de Análisis: Caso 1 (AnimalService.php) Single Responsibility Principle (Servicios)
1. ¿Cuántos 'actores' distintos tienen razones para pedir cambios a esta clase?
**Respuesta**: 3 actores.  

2. Nombre los ejes de cambio (cada razón independiente para cambiar):
Eje 1 (Lógica de Negocio): Cambios en las reglas de validación o en cómo se guarda el animal en la base de datos. 
Eje 2 (Notificaciones): Cambios en el proveedor de correos, en el formato del mensaje o en quién recibe la notificación.  
Eje 3 (Reportes/Infraestructura): Cambios en el diseño del PDF, la librería de generación de documentos o la ruta donde se almacenan.  

3. Si tuviéramos que escribir una prueba unitaria para la validación del arete, ¿qué dependencias habría que mockear?
**Respuesta**: Habría que mockear la persistencia de la base de datos (Animal::create), el servicio de correos (Mail) y el generador de PDF (Pdf/DomPDF), ya que están todos acoplados en el mismo método.




# Ficha de Análisis: Caso 2 (ReporteService.php)
1. ¿Cuántos archivos habría que modificar para agregar el tipo 'resumen_mensual'?
**Respuesta**: Actualmente 1 archivo (ReporteService.php). Con la corrección aplicada, serían 0 archivos existentes (solo se crearía la clase nueva).  

2. ¿Qué abstracción (interfaz o clase base) permitiría agregar nuevos tipos sin tocar ReporteService?
**Respuesta**: Una Interfaz llamada ReporteInterface que obligue a implementar el método generar(int $ranchoId).

3. ¿Cómo debería ReporteService recibir el generador correcto?
**Respuesta**: Mediante Inyección de Dependencias en el constructor o utilizando un Mapa de Estrategias (Strategy Pattern).




# Caso 3: LSP - Liskov Substitution Principle (Modelos)
**1. Diagnóstico**: `AnimalSinPeso` violaba el contrato de su clase padre al lanzar excepciones en métodos que el cliente esperaba que funcionaran, como `agregarRegistroPeso()`[cite: 172, 178].
* **2. Solución**: Se reestructuró la jerarquía en `app/Models`. Ahora `Animal` es la base común y se creó `AnimalConPeso` para especializar el comportamiento de pesaje, permitiendo que el código sea sustituible sin errores.
**3.** Crear una clase base Animal (con identidad y datos generales) y una subclase o interfaz AnimalPesable que contenga el método agregarRegistroPeso(). Así, AnimalSinPeso solo heredaría de la base general.




# Caso 4: ISP - Interface Segregation Principle (Interfaces)
**1. Diagnóstico**: La interfaz `IGestorAnimal` era una "interfaz gorda" que obligaba a clases de solo lectura a implementar métodos de escritura vacíos (stubs).
**2. Solución**: Se segregó el contrato en interfaces cohesivas en `app/Contracts`: `IAnimalReader` y `IAnimalWriter`, eliminando la dependencia de métodos no utilizados.
**3.** Respuesta: En dos interfaces: IAnimalReader (para métodos de lectura/consultas) e IAnimalWriter (para métodos de escritura/comandos).



# Ficha de Análisis: Caso 5 (EstimadorPesoService.php)
1. Identifique el módulo de alto nivel y el módulo de bajo nivel:
Alto nivel: EstimadorPesoService (Contiene la lógica de coordinación y reglas de negocio).
Bajo nivel: Illuminate\Support\Facades\Http (Detalle de infraestructura para comunicación externa).

2. ¿Cuántos pasos se necesitarían para escribir un test unitario de estimar() sin levantar Flask?
**Respuesta**: Actualmente es imposible sin usar herramientas de "faking" complejas del framework. Si se aplica DIP, solo se necesitaría un paso: crear un "Mock" o "Stub" de la interfaz de estimación.

3. Proponga el nombre de la interfaz (abstracción) que debería interponerse:
**Respuesta**: IEstimadorPesoExternalService o WeightEstimatorInterface.

