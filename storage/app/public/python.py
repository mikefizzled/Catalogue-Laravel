import json

# Name of complete eBird API export
with open("ebird_taxonomy.json", "r") as f:
    data = json.load(f)

# Extract unique families using a dictionary (ensures uniqueness)
unique_families = {}
for bird in data:
    family_sci = bird["familySciName"]
    if family_sci not in unique_families:
        unique_families[family_sci] = {
            "familyCode": bird["familyCode"],
            "familyComName": bird["familyComName"],
            "familySciName": family_sci,
            "order": bird["order"]
        }

# Convert to a list for JSON output
unique_families_list = list(unique_families.values())

# Save the stripped-down JSON file
with open("ebird_unique_families.json", "w") as f:
    json.dump(unique_families_list, f, indent=4)

print(f"Extracted {len(unique_families_list)} unique families.")
