<!-- from home -->

<select class="p-4 border block w-full mt-3" id="customer_name" name="customer_name">
    <option value="" selected disabled>Select a name</option>
    <?php foreach ($drivers_name as $person): ?>
        <option value="<?php echo $person['name']; ?>"><?php echo $person['name']; ?></option>
    <?php endforeach; ?>
</select>
<input class="p-4 border block w-full mt-3" type="text" id="customer_name" name="customer_name" placeholder="Name"
    required>