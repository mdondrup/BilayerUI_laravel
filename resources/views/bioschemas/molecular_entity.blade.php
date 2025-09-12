<!-- script type="application/ld+json" -->
 <pre>
{!! json_encode([
    '@context' => 'https://schema.org/',
    '@type' => 'MolecularEntity',
    '@id' => $entity->idUrl ?? url()->current(),  // or some canonical URL or IRI
    'http://purl.org/dc/terms/conformsTo' => [
        '@id' => 'https://bioschemas.org/profiles/MolecularEntity/0.5-RELEASE',
        '@type' => 'CreativeWork'
    ],
    'identifier' => $entity->identifier, 
    'name' => $entity->name,
    'url' => $entity->url ?? url()->current(),

    // Optional / recommended
    'inChI' => $entity->inChi ?? null,
    'inChIKey' => $entity->inChiKey ?? null,
    'iupacName' => $entity->iupac_name ?? null,
    'molecularFormula' => $entity->molecular_formula ?? null,
    'molecularWeight' => $entity->molecular_weight ?? null,
    'smiles' => $entity->smiles ?? null,

    'alternateName' => $entity->alternate_names ?? null,  // array
    'description' => $entity->description ?? null,
    'image' => $entity->image_url ?? null,
    'sameAs' => $entity->same_as_url ?? null,

    // If you have more relationships:
    'biologicalRole' => $entity->biological_roles ?? null,  // e.g. an array of DefinedTerm objects
    'chemicalRole' => $entity->chemical_roles ?? null,
    'bioChemInteraction' => $entity->interactions ?? null,
    'bioChemSimilarity' => $entity->similar_entities ?? null,

    // any others you have...
], JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT) !!}
</pre>
<!-- /script -->
