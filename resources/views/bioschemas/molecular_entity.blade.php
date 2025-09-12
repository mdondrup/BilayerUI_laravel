<?php
// Prepare data for JSON-LD
$props = $entity['properties'] ?? [];
// Flatten properties into a key-value array for easier access
foreach ($props as $prop) {    
        $entity['properties_flat'][$prop->name] = $prop->value . ($prop->unit ?? '');
    }
?>

@php
    $jsonLd = json_encode(array_filter([
        '@context' => 'https://schema.org/',
        '@type' => 'MolecularEntity',
        '@id' => $entity['idUrl'] ?? url()->current(),
        'http://purl.org/dc/terms/conformsTo' => [
            '@id' => 'https://bioschemas.org/profiles/MolecularEntity/0.5-RELEASE',
            '@type' => 'CreativeWork'
        ],
        'identifier' => $entity['identifier'] ?? null,
        'name' => $entity['name'] ?? null,
        'url' => $entity['url'] ?? url()->current(),
        'inChI' => $entity['properties_flat']['inChI'] ?? null,
        'inChIKey' => $entity['properties_flat']['inChIKey'] ?? null,
        'iupacName' => $entity['properties_flat']['iupacName'] ?? null,
        'molecularFormula' => $entity['properties_flat']['molecularFormula'] ?? null,
        'molecularWeight' => $entity['properties_flat']['molecularWeight'] ?? null,
        'smiles' => $entity['properties_flat']['smiles'] ?? null,
        'alternateName' => $entity['properties_flat']['alternateName'] ?? null,
        'description' => $entity['properties_flat']['description'] ?? null,
        'image' => $entity['properties_flat']['image'] ?? null,
        'sameAs' => $entity['properties_flat']['sameAs'] ?? null,
        'biologicalRole' => $entity['properties_flat']['biologicalRole'] ?? null,
        'chemicalRole' => $entity['properties_flat']['chemicalRole'] ?? null,
        'bioChemInteraction' => $entity['properties_flat']['bioChemInteraction'] ?? null,
        'bioChemSimilarity' => $entity['properties_flat']['bioChemSimilarity'] ?? null,
    ], fn($v) => !is_null($v)), JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
@endphp

{{-- Machine-readable JSON-LD --}}
<script type="application/ld+json">
{!! $jsonLd !!}
</script>

{{-- Toggle with a triangle --}}
<div style="margin-top:0.5rem;margin-bottom:0.5rem;">
    <span id="json-toggle-btn" 
          style="cursor:pointer;user-select:none;font-size:0.8em;color:#eeeeee;">
        ▸ View JSON
    </span>
</div>

<pre id="json-preview"
     style="display:none;margin-top:0.5rem;padding:0.5rem;background:#f3f4f6;font-size:0.8rem;border-radius:0.25rem;overflow-x:auto;">
{!! e($jsonLd) !!}
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



