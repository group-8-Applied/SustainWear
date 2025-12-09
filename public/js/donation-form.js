// same as in php
const sizeOptions = {
	"Coat": ["XS", "S", "M", "L", "XL", "XXL"],
	"Jeans": ["26", "28", "30", "32", "34", "36", "38", "40", "42"],
	"T-Shirt": ["XS", "S", "M", "L", "XL", "XXL"],
	"Shoes": ["3", "4", "5", "6", "7", "8", "9", "10", "11", "12", "13", "14"]
};

// store copies of original elements
const origTypeSelect = document.getElementById("item_type");
const typeSelectParent = document.getElementById("item_type").parentElement;

const origSizeSelect = document.getElementById("size");
const sizeSelectParent = document.getElementById("size").parentElement;

function createInputElement(name, placeholder, className) {
	const input = document.createElement("input");

	// configure
	input.type = "text";
	input.id = name;
	input.name = name;
	input.placeholder = placeholder;
	input.className = className;
	input.required = true;

	return input;
}

function removeSizeOptions(sizeElement) {
	sizeElement.innerHTML = ""; // clear options

	const option = document.createElement("option");
	option.value = "";
	option.textContent = "Select item type first...";
	sizeElement.appendChild(option);
}

// when selecting item type
origTypeSelect.addEventListener("change", function() {
	const itemTypeElement = document.getElementById("item_type");
	const sizeElement = document.getElementById("size");
	const selectedType = itemTypeElement.value;

	if (selectedType === "Other") { // user wants to enter input
		// swap select/options with inputs
		const itemTypeInput = createInputElement("item_type", "Describe the item (e.g. Scarf, Hat)", itemTypeElement.className);
		typeSelectParent.replaceChild(itemTypeInput, itemTypeElement);

		const sizeInput = createInputElement("size", "Enter size (e.g. S, XL, 10)", sizeElement.className);
		sizeSelectParent.replaceChild(sizeInput, sizeElement);

		// detect when deselecting item type input box
		itemTypeInput.addEventListener("blur", function() {
			// if user deselects without entering anything, revert to original state
			if (this.value.trim() === "") {
				const newItemTypeSelect = origTypeSelect;
				newItemTypeSelect.value = "";
				typeSelectParent.replaceChild(newItemTypeSelect, this);

				const newSizeSelect = origSizeSelect;
				sizeSelectParent.replaceChild(newSizeSelect, document.getElementById("size"));

				removeSizeOptions(newSizeSelect);
			}
		});
	} else {
		// regular clothing item
		if (selectedType && sizeOptions[selectedType]) {
			sizeElement.innerHTML = ""; // clear options
			// add correct options for current item type
			sizeOptions[selectedType].forEach(size => {
				const option = document.createElement("option");
				option.value = size;
				option.textContent = size;
				sizeElement.appendChild(option);
			});
		} else { // "pick an item..."
			removeSizeOptions(sizeElement);
		}
	}
});
