document.addEventListener("click", async (e) => {
  const btn = e.target.closest("[data-like-house]");
  if (!btn) return;

  const houseId = btn.getAttribute("data-like-house");
  const counter = document.querySelector(`[data-like-count="${houseId}"]`);

  const form = new FormData();
  form.append("house_id", houseId);

  const r = await fetch("/includes/likes_controller.php", {
    method: "POST",
    body: form
  });

  const data = await r.json();

  if (data.alreadyLiked) {
    btn.disabled = true;
    btn.textContent = "Вже лайкнуто ✅";
    return;
  }

  if (data.ok) {
    if (counter) counter.textContent = data.likes;
    btn.disabled = true;
    btn.textContent = "Лайк ✅";
  }
});
