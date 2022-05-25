import { useState } from "react";
import { Card, ToggleButton } from "react-bootstrap";

const Filter = ({ handleFilter }) => {
  const [radioValue, setRadioValue] = useState(0);

  const radios = [
    { id: 0, name: "Tất cả", sort: "all" },
    { id: 1, name: "Giá tăng dần", sort: "price_asc" },
    { id: 2, name: "Giá giảm dần", sort: "price_desc" },
    { id: 3, name: "Tên A-Z", sort: "name_asc" },
    { id: 4, name: "Tên Z-A", sort: "name_desc" },
  ];

  return (
    <Card className="shadow-sm ">
      <Card.Header>Sắp xếp</Card.Header>
      <Card.Body>
        <div className="d-grid gap-2 px-3">
          {radios.map((radio) => (
            <ToggleButton
              name="filter"
              key={radio.id}
              id={radio.id}
              type="radio"
              value={radio.sort}
              variant={
                radioValue === radio.id ? "outline-success" : "outline-primary"
              }
              checked={radioValue === radio.id}
              onChange={(e) => {
                setRadioValue(radio.id);
                handleFilter(radio.sort);
              }}
            >
              {radio.name}
            </ToggleButton>
          ))}
        </div>
      </Card.Body>
    </Card>
  );
};

export default Filter;
