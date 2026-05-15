# 🐄 Lab: Diagnóstico y Reparación SOLID - BovWeight CR

Este proyecto consiste en la identificación y corrección de violaciones a los principios SOLID en un sistema de gestión ganadera desarrollado en Laravel. A continuación, se detallan los hallazgos y las soluciones implementadas por el equipo.

---

## 🛠️ Reparaciones y Análisis de los Casos

### Caso 1: SRP - Single Responsibility Principle (Servicios)
* **Diagnóstico**: La clase `AnimalService` funcionaba como una "Clase Dios", manejando tres actores distintos: Lógica de negocio, Notificaciones y Generación de PDF.
* **Ejes de Cambio**:
    1.  **Lógica de Negocio**: Validación y persistencia de datos del animal.
    2.  **Notificaciones**: Formato y envío de correos al propietario.
    3. **Infraestructura de Reportes**: Diseño y almacenamiento de archivos PDF.

### Caso 3: LSP - Liskov Substitution Principle (Modelos)
**1. Diagnóstico**: `AnimalSinPeso` violaba el contrato de su clase padre al lanzar excepciones en métodos que el cliente esperaba que funcionaran, como `agregarRegistroPeso()`[cite: 172, 178].
* **2. Solución**: Se reestructuró la jerarquía en `app/Models`. Ahora `Animal` es la base común y se creó `AnimalConPeso` para especializar el comportamiento de pesaje, permitiendo que el código sea sustituible sin errores.
**3.** Crear una clase base Animal (con identidad y datos generales) y una subclase o interfaz AnimalPesable que contenga el método agregarRegistroPeso(). Así, AnimalSinPeso solo heredaría de la base general.
### Caso 4: ISP - Interface Segregation Principle (Interfaces)
**1. Diagnóstico**: La interfaz `IGestorAnimal` era una "interfaz gorda" que obligaba a clases de solo lectura a implementar métodos de escritura vacíos (stubs).
**2. Solución**: Se segregó el contrato en interfaces cohesivas en `app/Contracts`: `IAnimalReader` y `IAnimalWriter`, eliminando la dependencia de métodos no utilizados.
**3.** Respuesta: En dos interfaces: IAnimalReader (para métodos de lectura/consultas) e IAnimalWriter (para métodos de escritura/comandos).

### Caso 5: DIP - Dependency Inversion Principle (Infraestructura)
**1. Diagnóstico**: `EstimadorPesoService` dependía directamente de una URL hardcodeada y del cliente HTTP de Laravel, acoplando la lógica de negocio a detalles de infraestructura (Flask/Python).
* **2. Análisis de Capas**:
**Alto Nivel**: `EstimadorPesoService` (Lógica de estimación).
**Bajo Nivel**: Cliente HTTP / Microservicio Flask.
**Solución**: Se propone una abstracción (Interfaz) para que el servicio de alto nivel no conozca los detalles del envío HTTP, permitiendo probar la lógica sin necesidad de tener el servidor de Python activo.
**3**
IPesoEstimator o MLServiceContract
---

## 📂 Estructura del Código
* **Modelos**: `app/Models/Animal.php` y `app/Models/AnimalConPeso.php`.
* **Interfaces (Contratos)**: `app/Contracts/IAnimalReader.php`, `app/Contracts/IAnimalWriter.php` y la abstracción para el servicio ML.
* **Servicios**: Lógica desacoplada para cumplir con SRP y DIP.

---
**UCR - Sede Guanacaste** | Ingeniería del Software | Prof. Alonso Chavarría

**Estudiantes:** Ashley Dariana Narvaez Umaña C35538
Nathalie Tamara Caballero Jarquín C31386