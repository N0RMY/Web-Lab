import { useEffect, useState } from "react";
import { db, analytics } from "./firebase";  // імпортуємо готові db та analytics
import { collection, getDocs } from "firebase/firestore";
import { logEvent } from "firebase/analytics";
import "./App.css";

interface Product {
  id?: string;
  name?: string;
  price?: number;
}

function App() {
  const [products, setProducts] = useState<Product[]>([]);

  useEffect(() => {
    // відстеження події перегляду сторінки
    if (analytics) logEvent(analytics, "page_view");

    const fetchProducts = async () => {
      const querySnapshot = await getDocs(collection(db, "products"));
      const items = querySnapshot.docs.map(doc => ({ id: doc.id, ...doc.data() })) as Product[];
      setProducts(items);
    };

    fetchProducts();
  }, []);

  const handleButtonClick = () => {
    // Лог події для натискання на кнопку
    logEvent(analytics!, "button_click", { button_name: "my_test_button" });
    alert("Кнопка натиснута!");
  };

  return (
    <div>
      <h1>Firebase Products</h1>
      <pre>{JSON.stringify(products, null, 2)}</pre>

      {/* Кнопка, натискання на яку відслідковується */}
      <button onClick={handleButtonClick}>Натисни мене</button>
    </div>
  );
}
export default App;
