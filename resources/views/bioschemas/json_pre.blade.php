{{-- Toggle with a triangle --}}
<div style="margin-top:0.5rem;margin-bottom:0.5rem;">
    <span id="json-toggle-btn" 
          style="cursor:pointer;user-select:none;font-size:0.8em;color:#eeeeee;">
        ▸ View JSON
    </span>
</div>

<pre id="json-preview"
     style="display:none;margin-top:0.5rem;padding:0.5rem;background:#f3f4f6;font-size:0.8rem;border-radius:0.25rem;overflow-x:auto;">
{!! $entity['jsonLd'] !!}
</pre>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const btn = document.getElementById("json-toggle-btn");
        const pre = document.getElementById("json-preview");

        btn.addEventListener("click", function () {
            if (pre.style.display === "none") {
                pre.style.display = "block";
                btn.textContent = "▾ Hide JSON";
            } else {
                pre.style.display = "none";
                btn.textContent = "▸ View JSON";
            }
        });
    });
</script>